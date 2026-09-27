<?php
/**
 * ============================================================================
 *  CONTROLADOR DE PEDIDOS
 *  Patron aplicado: MVC bien aplicado (arquitectonico) + SRP
 * ============================================================================
 *
 *  Antes, create() mezclaba las tres capas de MVC en un solo metodo:
 *  arma SQL directamente, contenia reglas de negocio (descuentos),
 *  imprimia HTML con echo, creaba con new todas sus dependencias
 *  concretas y repetia por tercera vez el if de notificaciones.
 *
 *  Tener las carpetas /Controllers /Models /views NO significa aplicar MVC.
 *  MVC es separacion de responsabilidades, no estructura de directorios.
 *
 *  Ahora el controlador solo: recibe la entrada, delega TODO en la
 *  fachada (OrderFacade), y elige que vista renderizar (Ejercicio 7).
 * ============================================================================
 */

class OrderController
{
    private OrderFacade $facade;

    public function __construct()
    {
        $events = new OrderSubject();
        $events->subscribe(new EmailObserver());
        $events->subscribe(new SmsObserver());
        $events->subscribe(new DashboardObserver());

        $this->facade = new OrderFacade($events);
    }

    /**
     * ✅ EJERCICIO 7 (TP) — resuelto: sin SQL, sin reglas de negocio y sin
     *    echo. Toda la logica vive en OrderFacade; este metodo solo lee la
     *    entrada, delega y elige la vista.
     */
    public function create(): void
    {
        $order = $this->facade->createOrder(
            (int) ($_GET['id'] ?? 1),
            (string) ($_GET['paciente'] ?? 'Juan Perez'),
            (float) ($_GET['monto'] ?? 15000),
            (string) ($_GET['tipo'] ?? 'obra_social'),
            'email',
            'paciente@mail.com'
        );

        require __DIR__ . '/../../views/orders.php';
    }

    public function index(): void
    {
        require __DIR__ . '/../../views/orders.php';
    }

    /**
     * ✅ Resuelto en feat/patron-decorator (Ejercicio 4): decoradores
     *    explicitos en vez de banderas booleanas.
     */
    public function report(): void
    {
        $reporte = new WatermarkDecorator(
            new PdfReportDecorator(
                new DigitalSignatureDecorator(
                    new BasicReport('Pedidos del dia')
                )
            )
        );

        echo $reporte->generate();
    }
}
