<?php
/**
 * ============================================================================
 *  FACHADA DE PEDIDOS
 *  Patron aplicado: FACADE (estructural) + separacion en pasos cohesivos
 * ============================================================================
 *
 *  Antes, procesarPedidoCompleto() hacia de todo: validaba, calculaba,
 *  guardaba, notificaba, generaba reporte E imprimia HTML, con mas de
 *  6 responsabilidades y 4 niveles de anidamiento en un solo metodo.
 *  Ademas repetia el if por tipo de notificacion que ya resolvio
 *  NotificationFactory.
 *
 *  Ahora createOrder() ORQUESTA los pasos (validar, calcular con
 *  PricingStrategy, persistir, notificar) en menos de 10 lineas
 *  (Ejercicio 6). El reporte y la presentacion HTML NO son responsabilidad
 *  de esta clase: por eso no aparecen aca (ver OrderController::report()
 *  y views/orders.php).
 *
 *  ⚠️ Advertencia (la misma que trae el archivo original): una fachada
 *  COORDINA. Si createOrder() empezara a decidir reglas de negocio nuevas
 *  en vez de delegarlas, volveriamos al punto de partida.
 * ============================================================================
 */

final class OrderFacade
{
    public function __construct(private OrderSubject $events)
    {
    }

    public function createOrder(
        int $id,
        string $paciente,
        float $monto,
        string $tipoPaciente,
        string $tipoNotificacion,
        string $destino
    ): Order {
        $this->validar($paciente, $monto);
        $total = $this->calcularTotal($monto, $tipoPaciente);
        $order = new Order($id, $paciente, $total, $tipoPaciente);
        $order->guardar();
        NotificationFactory::create($tipoNotificacion, $destino)->send("Pedido {$id} por $ {$total}");
        $this->events->notify($order);

        return $order;
    }

    private function validar(string $paciente, float $monto): void
    {
        if (trim($paciente) === '') {
            throw new InvalidArgumentException('Falta el paciente');
        }

        if ($monto <= 0) {
            throw new InvalidArgumentException('Monto invalido');
        }
    }

    // Reutiliza el Strategy de src/Pricing en vez de repetir los porcentajes
    // por cuarta vez en el proyecto.
    private function calcularTotal(float $monto, string $tipoPaciente): float
    {
        $strategy = match ($tipoPaciente) {
            'obra_social' => new InsuranceStrategy(),
            'jubilado'    => new RetiredPatientStrategy(),
            'prepaga'     => new PrepaidStrategy(),
            default       => new PrivatePatientStrategy(),
        };

        return (new PriceCalculator($strategy))->calculate($monto);
    }
}
