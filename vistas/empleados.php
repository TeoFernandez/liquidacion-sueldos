<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}
include("../includes/conexion.php");

// Obtener empleados actuales
$sql = "SELECT * FROM empleados ORDER BY nombre ASC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/empleados.css">
    <title>Empleados</title>
</head>
<body>
    <h2>Listado de Empleados</h2>

    <table border="1" cellpadding="5">
        <tr>
            <th>Nombre</th>
            <th>DNI</th>
            <th>Fecha ingreso</th>
            <th>Puesto</th>
            <th>Sueldo bruto</th>
            <th>Descuento (%)</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($fila["nombre"]) ?></td>
                <td><?= $fila["dni"] ?></td>
                <td><?= $fila["fecha_ingreso"] ?></td>
                <td><?= $fila["puesto"] ?></td>
                <td>$<?= number_format($fila["sueldo_bruto"], 2) ?></td>
                <td><?= $fila["descuento_porcentaje"] ?>%</td>
                <td><a href="editar_empleado.php?id=<?= $fila["id_empleado"] ?>">Editar</a></td>
                <td><a href="../includes/eliminar_empleado.php?id=<?= $fila["id_empleado"] ?>" onclick="return confirm('¿Estás seguro de que querés eliminar este empleado?');">Eliminar</a></td>
            </tr>
        <?php } ?>
    </table>

    <h3>Agregar nuevo empleado</h3>
    <form action="../includes/guardar_empleado.php" method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>DNI:</label><br>
        <input type="text" name="dni" required><br><br>

        <label>Fecha de ingreso:</label><br>
        <input type="date" name="fecha_ingreso" required><br><br>

        <label>Puesto:</label><br>
        <input type="text" name="puesto" required><br><br>

        <label>Sueldo bruto:</label><br>
        <input type="number" name="sueldo_bruto" step="0.01" required><br><br>

        <label>Descuento (%):</label><br>
        <input type="number" name="descuento_porcentaje" step="0.01" value="0"><br><br>

        <input type="submit" value="Guardar empleado">
    </form>

    <br><a href="panel.php">← Volver al panel</a>
</body>
</html>
