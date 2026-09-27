<?php
/**
 * ============================================================================
 *  EJERCICIO 3 (TP) — resuelto
 *  Patron aplicado: ADAPTER (estructural)
 * ============================================================================
 *
 *  Antes: alguien habia copiado el cuerpo de sendMessage() dentro de
 *  CopiaDeLegacyEnNuestroSistema (duplicacion), y otro alguien habia
 *  agregado un metodo send() DENTRO de la clase del proveedor (modificar
 *  codigo de terceros: en la proxima actualizacion del proveedor, ese
 *  metodo desaparece y el sistema se rompe sin que nadie sepa por que).
 *
 *  Ahora: este Adapter implementa NUESTRO contrato (Notification) y
 *  traduce la llamada al metodo del proveedor. La incompatibilidad queda
 *  encerrada en este unico archivo.
 *
 *  Estructura:
 *    Nuestro sistema -> Notification <- LegacyNotifierAdapter -> LegacyNotifier
 * ============================================================================
 */

final class LegacyNotifierAdapter implements Notification
{
    // COMPOSICION: el adapter TIENE el sistema viejo adentro.
    public function __construct(private LegacyNotifier $legacy)
    {
    }

    public function send(string $message): void
    {
        $this->legacy->sendMessage($message);
    }
}
