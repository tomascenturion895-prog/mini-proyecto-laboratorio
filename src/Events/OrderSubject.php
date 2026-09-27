<?php
/**
 * ============================================================================
 *  SUJETO DE AVISOS AL CREARSE UN PEDIDO
 *  Patron aplicado: OBSERVER (comportamiento)
 * ============================================================================
 *
 *  Reemplaza a OrderEvents::pedidoCreado(). Mantiene una coleccion de
 *  OrderObserver (interfaces, no clases concretas) y les avisa a todos.
 *  Agregar un aviso nuevo es agregar un observador y suscribirlo, no
 *  modificar esta clase.
 *
 *  CONSECUENCIA A JUSTIFICAR (ver docs/DEUDA-TECNICA.md): leyendo el
 *  codigo del pedido ya no se ve, a simple vista, quien se entera del
 *  evento — eso se compensa con nombres explicitos por observador
 *  (EmailObserver, SmsObserver, DashboardObserver) y con este mismo
 *  comentario documentando donde se suscriben.
 * ============================================================================
 */

final class OrderSubject
{
    /** @var OrderObserver[] */
    private array $observers = [];

    public function subscribe(OrderObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function notify(Order $order): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($order);
        }
    }
}
