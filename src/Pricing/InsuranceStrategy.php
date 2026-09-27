<?php
/**
 * Paciente con obra social: descuento configurable (30% por defecto, es decir
 * paga el 70% del monto). El porcentaje deja de estar hardcodeado y repetido
 * en cada archivo: vive en un unico lugar.
 */
final class InsuranceStrategy implements PricingStrategy
{
    public function __construct(private float $discount = 0.30)
    {
    }

    public function calculate(float $amount): float
    {
        return $amount * (1 - $this->discount);
    }
}
