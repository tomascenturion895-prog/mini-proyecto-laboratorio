<?php
/**
 * ============================================================================
 *  EJERCICIO 4 (TP) — resuelto (2/2)
 * ============================================================================
 *
 *  Agrega marca de agua al reporte que envuelve.
 *
 *  CONSECUENCIA A JUSTIFICAR: el orden de los decoradores cambia el
 *  resultado (firmar y despues pasar a PDF no es lo mismo que al reves).
 *  Esa restriccion queda documentada en docs/DEUDA-TECNICA.md y en el
 *  ejemplo de uso de ReportGenerator.php: se recomienda el orden
 *  Basic -> Signature -> Pdf -> Watermark porque la marca de agua es un
 *  agregado visual que debe quedar "por encima" de cualquier otro sello.
 * ============================================================================
 */
final class WatermarkDecorator implements Report
{
    public function __construct(private Report $report)
    {
    }

    public function generate(): string
    {
        return $this->report->generate() . ' + marca de agua';
    }
}
