<?php
/**
 * ============================================================================
 *  CONTRATO DE REPORTE — DECORATOR
 * ============================================================================
 *
 *  Antes, ReportGenerator::generate() recibia banderas booleanas
 *  (generate($contenido, true, false, true)) y nadie recordaba, seis meses
 *  despues, cual bandera era cual. Con 3 banderas hay 8 combinaciones
 *  dentro del mismo metodo; con 5, hay 32.
 *
 *  Ahora cada agregado es un decorador que envuelve un Report y se puede
 *  combinar en tiempo de ejecucion, sin tocar las clases existentes.
 * ============================================================================
 */

interface Report
{
    public function generate(): string;
}
