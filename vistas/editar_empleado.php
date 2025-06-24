<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}
include("../Back-end/conexion.php");

$id = $_GET["id"] ?? 0;

$sql = "SELECT * FROM empleados WHERE id_empleado = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    echo "Empleado no encontrado.";
    exit();
}

$empleado = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/editar_empleado.css">
    <title>Editar Empleado</title>
</head>
<body>
    <h2>Editar empleado</h2>
    <form action="../Back-end/actualizar_empleado.php" method="POST">
        <input type="hidden" name="id_empleado" value="<?= $empleado["id_empleado"] ?>">

        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?= $empleado["nombre"] ?>" required><br><br>

        <label>DNI:</label><br>
        <input type="text" name="dni" value="<?= $empleado["dni"] ?>" required><br><br>

        <label>Fecha de ingreso:</label><br>
        <input type="date" name="fecha_ingreso" value="<?= $empleado["fecha_ingreso"] ?>" required><br><br>

        <label>Puesto:</label><br>
        <input type="text" name="puesto" value="<?= $empleado["puesto"] ?>" required><br><br>

        <label>Sueldo bruto:</label><br>
        <input type="number" name="sueldo_bruto" step="0.01" value="<?= $empleado["sueldo_bruto"] ?>" required><br><br>

        <label>Descuento (%):</label><br>
        <input type="number" name="descuento_porcentaje" step="0.01" value="<?= $empleado["descuento_porcentaje"] ?>"><br><br>

        <input type="submit" value="Actualizar empleado">
    </form>

    <br><a href="empleados.php">← Volver</a>
</body>
</html>
