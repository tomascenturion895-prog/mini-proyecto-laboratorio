<?php
/**
 * ============================================================================
 *  CALCULO DE PRECIOS
 *  Patron aplicado: STRATEGY (comportamiento)
 * ============================================================================
 *
 *  Antes: un switch concentraba todos los algoritmos de precio y el 0.7 de
 *  obra social estaba escrito a mano y repetido en otros archivos.
 *
 *  Ahora: PriceCalculator solo compone una PricingStrategy y delega en ella.
 *  Agregar un tipo de paciente nuevo (ver PrepaidStrategy) es agregar una
 *  clase, no modificar esta.
 * ============================================================================
 */

final class PriceCalculator
{
    // COMPOSICION: PriceCalculator TIENE una estrategia (no hereda de ella).
    public function __construct(private PricingStrategy $strategy)
    {
    }

    public function calculate(float $amount): float
    {
        return $this->strategy->calculate($amount);
    }

    public function calculateWithTax(float $amount, float $tax = 0.21): float
    {
        return $this->calculate($amount) * (1 + $tax);
    }
}
