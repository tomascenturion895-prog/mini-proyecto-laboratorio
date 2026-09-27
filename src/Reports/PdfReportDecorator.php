<?php
/**
 * ============================================================================
 *  EJERCICIO 4 (TP) — resuelto (1/2)
 * ============================================================================
 *
 *  Agrega el agregado "PDF" al reporte que envuelve.
 * ============================================================================
 */
final class PdfReportDecorator implements Report
{
    public function __construct(private Report $report)
    {
    }

    public function generate(): string
    {
        return $this->report->generate() . ' + PDF';
    }
}
