<?php
/**
 * ============================================================================
 *  EJERCICIO 2 (TP) — resuelto
 * ============================================================================
 *
 *  Clase nueva para agregar WhatsApp. El unico otro archivo tocado es
 *  NotificationFactory.php (un `case` mas en el match). Ni el controlador
 *  ni el servicio se enteran de que existe esta clase.
 * ============================================================================
 */

final class WhatsAppNotification implements Notification
{
    public function __construct(private string $number)
    {
    }

    public function send(string $message): void
    {
        echo "[WHATSAPP] a {$this->number}: {$message}<br>";
    }
}
