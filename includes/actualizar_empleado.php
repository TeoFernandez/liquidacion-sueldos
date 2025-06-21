<?php
include("conexion.php");

$id = $_POST["id_empleado"];
$nombre = $_POST["nombre"];
$dni = $_POST["dni"];
$fecha_ingreso = $_POST["fecha_ingreso"];
$puesto = $_POST["puesto"];
$sueldo_bruto = $_POST["sueldo_bruto"];
$descuento = $_POST["descuento_porcentaje"];

$sql = "UPDATE empleados SET nombre=?, dni=?, fecha_ingreso=?, puesto=?, sueldo_bruto=?, descuento_porcentaje=?
        WHERE id_empleado=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssddi", $nombre, $dni, $fecha_ingreso, $puesto, $sueldo_bruto, $descuento, $id);
$stmt->execute();

header("Location: ../vistas/empleados.php");
exit();
