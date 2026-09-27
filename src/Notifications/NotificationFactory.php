<?php
/**
 * ============================================================================
 *  FABRICA DE NOTIFICACIONES
 *  Patron aplicado: FACTORY METHOD (creacional)
 * ============================================================================
 *
 *  Antes (NotificationSender::enviar()) el if por tipo de notificacion estaba
 *  repetido en tres lugares del sistema (aca, en OrderService y en
 *  OrderController), y agregar un tipo nuevo obligaba a tocar los tres.
 *
 *  Ahora una unica fabrica devuelve objetos que cumplen Notification. El
 *  resto del sistema deja de conocer las clases concretas.
 * ============================================================================
 */

final class NotificationFactory
{
    public static function create(string $type, string $destino): Notification
    {
        return match ($type) {
            'email'    => new EmailNotification($destino),
            'sms'      => new SmsNotification($destino),
            'whatsapp' => new WhatsAppNotification($destino),
            default    => throw new InvalidArgumentException(
                "Tipo de notificacion no soportado: {$type}"
            ),
        };
    }
}
