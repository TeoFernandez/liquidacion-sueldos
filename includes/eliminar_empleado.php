<?php
include("conexion.php");

$id = $_GET["id"] ?? 0;

$sql = "DELETE FROM empleados WHERE id_empleado = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: ../vistas/empleados.php");
exit();
