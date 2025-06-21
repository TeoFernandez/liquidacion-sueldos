<?php
include("conexion.php");

$nombre = $_POST["nombre"] ?? '';
$dni = $_POST["dni"] ?? '';
$fecha_ingreso = $_POST["fecha_ingreso"] ?? '';
$puesto = $_POST["puesto"] ?? '';
$sueldo_bruto = $_POST["sueldo_bruto"] ?? 0;
$descuento = $_POST["descuento_porcentaje"] ?? 0;

// Evitar campos vacíos
if ($nombre && $dni && $fecha_ingreso && $puesto) {
    $sql = "INSERT INTO empleados (nombre, dni, fecha_ingreso, puesto, sueldo_bruto, descuento_porcentaje)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdd", $nombre, $dni, $fecha_ingreso, $puesto, $sueldo_bruto, $descuento);
    $stmt->execute();
}

// Redirigir de nuevo a empleados.php
header("Location: ../vistas/empleados.php");
exit();
