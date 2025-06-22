<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}
include("../includes/conexion.php");

// Obtener lista de empleados
$sql = "SELECT id_empleado, nombre FROM empleados ORDER BY nombre ASC";
$empleados = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Liquidar Sueldo</title>
</head>
<body>
    <h2>Liquidación de Sueldos</h2>

    <form action="../includes/guardar_liquidacion.php" method="POST">
        <label>Empleado:</label><br>
        <select name="id_empleado" required>
            <option value="">Seleccione...</option>
            <?php while ($e = $empleados->fetch_assoc()) { ?>
                <option value="<?= $e['id_empleado'] ?>"><?= htmlspecialchars($e['nombre']) ?></option>
            <?php } ?>
        </select><br><br>

        <label>Mes (formato AAAA-MM):</label><br>
        <input type="month" name="mes" required><br><br>

        <input type="submit" value="Liquidar sueldo">
    </form>

    <br><a href="panel.php">← Volver al panel</a>
</body>
</html>
