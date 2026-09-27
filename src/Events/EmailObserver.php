<?php
/**
 * Avisa por email cuando se crea un pedido. Reutiliza la fabrica de
 * notificaciones (ver src/Notifications) en vez de instanciar la clase
 * concreta a mano.
 */
final class EmailObserver implements OrderObserver
{
    public function update(Order $order): void
    {
        NotificationFactory::create('email', 'paciente@mail.com')
            ->send("Pedido {$order->id} creado");
    }
}
