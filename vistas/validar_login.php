<?php
session_start();
include("conexion.php");

$usuario = $_POST["usuario"] ?? '';
$clave = $_POST["clave"] ?? '';

// Consulta segura con prepared statements
$sql = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usuario, $clave);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $_SESSION["usuario"] = $usuario;
    header("Location: panel.php");
} else {
    header("Location: login.php?error=1");
}
?>
