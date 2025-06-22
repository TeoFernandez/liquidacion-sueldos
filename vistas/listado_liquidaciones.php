<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}
include("../includes/conexion.php");

// Obtener lista de empleados para el formulario
$empleados_lista = $conn->query("SELECT id_empleado, nombre FROM empleados ORDER BY nombre ASC");

// Capturar filtros desde la URL (GET)
$filtro_empleado = $_GET["empleado"] ?? "";
$filtro_mes = $_GET["mes"] ?? "";

// Armar condiciones dinámicas
$where = [];
$params = [];
$tipos = "";

if (!empty($filtro_empleado)) {
    $where[] = "l.id_empleado = ?";
    $params[] = $filtro_empleado;
    $tipos .= "i";
}

if (!empty($filtro_mes)) {
    $where[] = "l.mes = ?";
    $params[] = $filtro_mes;
    $tipos .= "s";
}

$where_clause = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";

// Consulta final con filtros aplicados
$sql = "
    SELECT 
        l.id_liquidacion,
        l.mes,
        l.sueldo_bruto,
        l.descuento_aplicado,
        l.sueldo_neto,
        l.fecha_liquidacion,
        e.nombre AS empleado
    FROM liquidaciones l
    JOIN empleados e ON l.id_empleado = e.id_empleado
    $where_clause
    ORDER BY l.mes DESC, e.nombre ASC
";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($tipos, ...$params);
}
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/historial.css">
    <title>Listado de Liquidaciones</title>
</head>
<body>
    <h2>Historial de Liquidaciones</h2>

    <h2>Filtrar Liquidaciones</h2>
    <form method="GET">
        <label>Empleado:</label>
        <select name="empleado">
            <option value="">Todos</option>
            <?php while ($emp = $empleados_lista->fetch_assoc()): ?>
                <option value="<?= $emp['id_empleado'] ?>" <?= ($emp['id_empleado'] == $filtro_empleado) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($emp['nombre']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Mes:</label>
        <input type="month" name="mes" value="<?= $filtro_mes ?>">

        <input type="submit" value="Aplicar filtros">
        <a href="listado_liquidaciones.php">Limpiar</a>
    </form>

    <hr>

    <?php if ($resultado->num_rows > 0): ?>
        <table border="1" cellpadding="5">
            <tr>
                <th>Empleado</th>
                <th>Mes</th>
                <th>Sueldo bruto</th>
                <th>Descuento</th>
                <th>Sueldo neto</th>
                <th>Fecha de liquidación</th>
                <th>Recibo</th>
            </tr>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($fila["empleado"]) ?></td>
                    <td><?= $fila["mes"] ?></td>
                    <td>$<?= number_format($fila["sueldo_bruto"], 2) ?></td>
                    <td>$<?= number_format($fila["descuento_aplicado"], 2) ?></td>
                    <td>$<?= number_format($fila["sueldo_neto"], 2) ?></td>
                    <td><?= $fila["fecha_liquidacion"] ?></td>
                    <td><a href="recibo_pdf.php?id=<?= $fila["id_liquidacion"] ?>" target="_blank">📄 PDF</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No hay liquidaciones registradas con esos filtros.</p>
    <?php endif; ?>

    <br><a href="panel.php">← Volver al panel</a>
</body>
</html>
