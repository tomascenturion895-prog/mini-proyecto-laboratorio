<?php
/**
 * ============================================================================
 *  NOTIFICACION POR EMAIL
 * ============================================================================
 *
 *  Implementa el contrato Notification::send(). Antes se llamaba
 *  enviarEmail($destinatario, $asunto, $cuerpo); ahora el destinatario se
 *  recibe por constructor y el metodo publico es el mismo para cualquier
 *  tipo de notificacion.
 * ============================================================================
 */

final class EmailNotification implements Notification
{
    public function __construct(private string $to, private string $subject = 'Pedido del laboratorio')
    {
    }

    public function send(string $message): void
    {
        echo "[EMAIL] para {$this->to} | {$this->subject}: {$message}<br>";
    }
}
