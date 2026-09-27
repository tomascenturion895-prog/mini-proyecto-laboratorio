<?php
/**
 * ============================================================================
 *  CONTRATO DE CALCULO DE PRECIO — STRATEGY
 * ============================================================================
 *
 *  Reemplaza al switch de PriceCalculator (ver PriceCalculator.php).
 *  Cada tipo de paciente pasa a ser UNA clase que implementa esta interfaz,
 *  en lugar de un case dentro de un metodo gigante.
 * ============================================================================
 */

interface PricingStrategy
{
    public function calculate(float $amount): float;
}
