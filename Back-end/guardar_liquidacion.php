<?php
include("conexion.php");

$id_empleado = $_POST["id_empleado"] ?? 0;
$mes = $_POST["mes"] ?? '';

if (!$id_empleado || !$mes) {
    die("Faltan datos.");
}

// Obtener datos del empleado
$sql = "SELECT sueldo_bruto, descuento_porcentaje FROM empleados WHERE id_empleado = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_empleado);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    die("Empleado no encontrado.");
}

$empleado = $resultado->fetch_assoc();

$sueldo_bruto = $empleado["sueldo_bruto"];
$porcentaje_descuento = $empleado["descuento_porcentaje"];
$descuento = $sueldo_bruto * ($porcentaje_descuento / 100);
$sueldo_neto = $sueldo_bruto - $descuento;

// Insertar la liquidación
$sql = "INSERT INTO liquidaciones (id_empleado, mes, sueldo_bruto, descuento_aplicado, sueldo_neto)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issdd", $id_empleado, $mes, $sueldo_bruto, $descuento, $sueldo_neto);
$stmt->execute();

header("Location: ../vistas/liquidaciones.php");
exit();
