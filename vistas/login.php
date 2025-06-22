<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/login.css">
    <title>Login - Liquidación de Sueldos</title>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar sesión</h2>
        
        <form action="../includes/validar_login.php" method="POST">
            <label>Usuario:</label><br>
            <input type="text" name="usuario" required><br><br>

            <label>Contraseña:</label><br>
            <input type="password" name="clave" required><br><br>

            <input type="submit" value="Ingresar">
        </form>
        <?php
        if (isset($_GET["error"])) {
            echo "<p style='color:red;'>Usuario o contraseña incorrectos</p>";
        }
        ?>
    </div>
</body>
</html>
