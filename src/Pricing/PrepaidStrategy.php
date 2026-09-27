<?php
/**
 * ============================================================================
 *  EJERCICIO 1 (TP) — resuelto
 * ============================================================================
 *
 *  Paciente con prepaga: descuento del 20%, distinto al de obra social (30%)
 *  y al de jubilado (50%).
 *
 *  Se agrega esta clase nueva y NO se modifico PriceCalculator para que
 *  funcione: eso es exactamente lo que promete Strategy + Open/Closed.
 * ============================================================================
 */
final class PrepaidStrategy implements PricingStrategy
{
    public function __construct(private float $discount = 0.20)
    {
    }

    public function calculate(float $amount): float
    {
        return $amount * (1 - $this->discount);
    }
}
