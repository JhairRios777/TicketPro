<?php
// AuditReport.php (ejemplo independiente)
// Ajusta rutas según tu estructura
require_once __DIR__ . '/lib/fpdf186/fpdf.php';
require_once __DIR__ . '/Config/Conexion.php'; // si vas a leer DB aquí

// Obtén datos: ejemplo rápido (mejor obtener en tu controlador y pasar $rows)
$c = new Config\Conexion();
$pdo = $c->getConexion();
$stmt = $pdo->query("SELECT id, user_id, desk_id, ticket_id, action, details, date_time FROM audits ORDER BY date_time DESC LIMIT 200");
$rows = $stmt->fetchAll(PDO::FETCH_OBJ);

$pdf = new FPDF('P','mm','A4');
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10, utf8_decode('Reporte de Auditorías'), 0, 1, 'C');
$pdf->Ln(4);

// cabeceras de tabla
$pdf->SetFont('Arial','B',9);
$w = [10, 30, 30, 30, 25, 45]; // anchos aproximados: ID, Usuario, Desk, Ticket, Acción, Detalles
$pdf->Cell($w[0],7,'ID',1,0,'C');
$pdf->Cell($w[1],7,'Usuario',1,0,'C');
$pdf->Cell($w[2],7,'Desk',1,0,'C');
$pdf->Cell($w[3],7,'Ticket',1,0,'C');
$pdf->Cell($w[4],7,'Acción',1,0,'C');
$pdf->Cell($w[5],7,'Detalles',1,1,'C');

$pdf->SetFont('Arial','',8);

// rellena filas
foreach($rows as $r){
    // convierte/limita texto para evitar overflow
    $id = $r->id;
    $user = isset($r->user_id) ? utf8_decode((string)$r->user_id) : '';
    $desk = isset($r->desk_id) ? utf8_decode((string)$r->desk_id) : '';
    $ticket = isset($r->ticket_id) ? utf8_decode((string)$r->ticket_id) : '';
    $action = isset($r->action) ? utf8_decode((string)$r->action) : '';
    $details = isset($r->details) ? utf8_decode((string)$r->details) : '';

    // Si la celda de detalles puede tener mucho texto, usar MultiCell.
    $pdf->Cell($w[0],6,$id,1,0,'C');
    $pdf->Cell($w[1],6,$user,1,0,'L');
    $pdf->Cell($w[2],6,$desk,1,0,'L');
    $pdf->Cell($w[3],6,$ticket,1,0,'L');
    $pdf->Cell($w[4],6,$action,1,0,'L');

    // detalles: usaremos MultiCell en la última columna:
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell($w[5],6,$details,1,'L');
    // mover el cursor a la derecha de la multicelda para próxima fila
    $pdf->SetXY($x + $w[5], $y);
    $pdf->Ln(0);
}

// Envía al navegador para descarga (Forzar descarga):
$pdf->Output('D', 'reporte_auditorias.pdf');
exit;