<?php
/**
 * ============================================================================
 *  CONTRATO DE OBSERVADOR — OBSERVER
 * ============================================================================
 *
 *  Antes, OrderEvents::pedidoCreado() llamaba a mano, encadenado, a cada
 *  interesado (email, sms, dashboard): acoplamiento fuerte a tres clases
 *  concretas y, si uno fallaba, los siguientes no se ejecutaban.
 *
 *  Ahora el sujeto (OrderSubject) solo conoce esta interfaz, no las clases
 *  concretas que la implementan.
 * ============================================================================
 */

interface OrderObserver
{
    public function update(Order $order): void;
}
