<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel principal</title>
</head>
<body>
    <h2>Bienvenido, <?= htmlspecialchars($_SESSION["usuario"]) ?>!</h2>
    <p>Este es el panel principal del sistema de liquidación de sueldos.</p>
    <ul>
        <li><a href="empleados.php">Gestionar Empleados</a></li>
        <li><a href="liquidaciones.php">Liquidación</a></li>
        <li><a href="listado_liquidaciones.php">Listado de Liquidaciones</a></li>
    </ul>
    <p><a href="../logout.php">Cerrar sesión</a></p>
</body>
</html>
