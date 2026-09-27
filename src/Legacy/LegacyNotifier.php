<?php
/**
 * ============================================================================
 *  SISTEMA HEREDADO DEL LABORATORIO
 * ============================================================================
 *
 *  CONTEXTO: el laboratorio ya tenia un sistema de avisos hecho por otro
 *  proveedor. No lo podemos modificar: lo usan tambien Recepcion y
 *  Facturacion.
 *
 *  Esta clase queda EXACTAMENTE como la entrega el proveedor. La
 *  incompatibilidad con nuestro contrato Notification se resuelve afuera,
 *  en LegacyNotifierAdapter (ver LegacyNotifierAdapter.php), no adentro.
 * ============================================================================
 */

class LegacyNotifier
{
    /** Metodo original del proveedor. No lo podemos cambiar. */
    public function sendMessage(string $text): void
    {
        echo "[LEGACY] {$text}<br>";
    }
}
