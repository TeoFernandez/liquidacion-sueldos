<?php
require_once("../tcpdf/tcpdf.php");
include("../includes/conexion.php");

$id = $_GET["id"] ?? 0;

$sql = "
SELECT l.*, e.nombre, e.dni, e.puesto
FROM liquidaciones l
JOIN empleados e ON l.id_empleado = e.id_empleado
WHERE l.id_liquidacion = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Liquidación no encontrada.");
}

$liq = $result->fetch_assoc();


$pdf = new TCPDF();
$pdf->SetMargins(20, 40, 20); // margen superior más grande por el logo
$pdf->AddPage();
$pdf->Image('../img/logo.png', 150, 15, 40); // ruta, x, y, ancho
$pdf->SetFont('helvetica', '', 12);

$html = "
<h2>Recibo de Sueldo</h2>
<p><strong>Empleado:</strong> {$liq['nombre']}</p>
<p><strong>DNI:</strong> {$liq['dni']}</p>
<p><strong>Puesto:</strong> {$liq['puesto']}</p>
<p><strong>Mes:</strong> {$liq['mes']}</p>
<p><strong>Fecha de liquidación:</strong> {$liq['fecha_liquidacion']}</p>

<table border=\"1\" cellpadding=\"5\">
    <tr>
        <th>Concepto</th>
        <th>Importe</th>
    </tr>
    <tr>
        <td>Sueldo Bruto</td>
        <td>$" . number_format($liq['sueldo_bruto'], 2) . "</td>
    </tr>
    <tr>
        <td>Descuento</td>
        <td>-$" . number_format($liq['descuento_aplicado'], 2) . "</td>
    </tr>
    <tr>
        <td><strong>Sueldo Neto</strong></td>
        <td><strong>$" . number_format($liq['sueldo_neto'], 2) . "</strong></td>
    </tr>
</table>
";

$pdf->writeHTML($html);
$pdf->IncludeJS("print(true);"); // abre la impresión automática
$pdf->Output("recibo_{$liq['nombre']}_{$liq['mes']}.pdf", 'I'); // Mostrar en navegador
