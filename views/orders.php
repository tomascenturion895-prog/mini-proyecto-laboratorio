<?php
/**
 * ============================================================================
 *  VISTA: listado de pedidos
 * ============================================================================
 *
 *  Antes, esta vista abria su propia conexion a la base de datos, calculaba
 *  el total segun el tipo de paciente (regla de negocio en la capa de
 *  presentacion) e imprimia los datos sin escapar (XSS).
 *
 *  Ahora la vista NO tiene una sola linea de logica (Ejercicio 8): recibe
 *  $pedidos ya resuelto por el controlador (ver OrderController::index()
 *  y ::create()) y solo lo muestra, escapando toda la salida.
 * ============================================================================
 */
?>
<h1>Pedidos</h1>

<table border="1">
    <tr><th>ID</th><th>Paciente</th><th>Total</th></tr>

    <?php foreach ($pedidos as $pedido): ?>
        <tr>
            <td><?= htmlspecialchars((string) $pedido['id'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($pedido['paciente'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars(number_format((float) $pedido['total'], 2), ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
    <?php endforeach; ?>
</table>
