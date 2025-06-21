<?php
$host = "localhost";
$user = "root";         // cambiar si tu usuario es distinto
$pass = "";             // poner tu contraseña de MySQL si tiene
$dbname = "liquidacion_sueldos";

$conn = new mysqli($host, $user, $pass, $dbname);

// Verifica errores
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
