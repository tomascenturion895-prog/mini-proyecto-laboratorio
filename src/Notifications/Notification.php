<?php
/**
 * ============================================================================
 *  CONTRATO DE NOTIFICACION
 * ============================================================================
 *
 *  Antes, EmailNotification::enviarEmail() y SmsNotification::mandarSms()
 *  tenian firmas distintas para la misma responsabilidad: el cliente
 *  necesitaba un if por cada tipo para saber que metodo llamar.
 *
 *  Ahora toda notificacion cumple este mismo contrato: send(string $message).
 *  Mismo contrato => polimorfismo => el cliente no conoce la clase concreta.
 * ============================================================================
 */

interface Notification
{
    public function send(string $message): void;
}
