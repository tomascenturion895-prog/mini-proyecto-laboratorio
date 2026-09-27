<?php
/**
 * ============================================================================
 *  EJERCICIO 5 (TP) — resuelto
 * ============================================================================
 *
 *  Se agrega este observador nuevo SIN tocar OrderSubject (ver
 *  OrderSubject.php): el sujeto ya sabe recorrer cualquier OrderObserver.
 * ============================================================================
 */
final class SmsObserver implements OrderObserver
{
    public function update(Order $order): void
    {
        NotificationFactory::create('sms', '3704000000')
            ->send("Pedido {$order->id} creado");
    }
}
