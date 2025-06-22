<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}
include("../includes/conexion.php");

// Consulta con JOIN para traer datos del empleado
$sql = "
SELECT 
    l.id_liquidacion,
    l.mes,
    l.sueldo_bruto,
    l.descuento_aplicado,
    l.sueldo_neto,
    l.fecha_liquidacion,
    e.nombre AS empleado
FROM liquidaciones l
JOIN empleados e ON l.id_empleado = e.id_empleado
ORDER BY l.mes DESC, e.nombre ASC
";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Liquidaciones</title>
</head>
<body>
    <h2>Historial de Liquidaciones</h2>

    <?php if ($resultado->num_rows > 0): ?>
        <table border="1" cellpadding="5">
            <tr>
                <th>Empleado</th>
                <th>Mes</th>
                <th>Sueldo bruto</th>
                <th>Descuento</th>
                <th>Sueldo neto</th>
                <th>Fecha de liquidación</th>
            </tr>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($fila["empleado"]) ?></td>
                    <td><?= $fila["mes"] ?></td>
                    <td>$<?= number_format($fila["sueldo_bruto"], 2) ?></td>
                    <td>$<?= number_format($fila["descuento_aplicado"], 2) ?></td>
                    <td>$<?= number_format($fila["sueldo_neto"], 2) ?></td>
                    <td><?= $fila["fecha_liquidacion"] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No hay liquidaciones registradas aún.</p>
    <?php endif; ?>

    <br><a href="panel.php">← Volver al panel</a>
</body>
</html>
