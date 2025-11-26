<?php
    namespace Controllers;
    use Models\Audit as Audit;

    class AuditController {
        private $auditModel;
        
        public function __construct() {
            $this->auditModel = new Audit();
        }
        
        public function index() {
            $audits = $this->auditModel->toList();
            return $audits;  
        }

        // Generate PDF report for a single audit record (called via /Audit/View/{id})
        public function View($id) {
            $audit = $this->auditModel->getForId($id);
            if (!$audit) {
                echo "Registro de auditoría no encontrado.";
                return;
            }

            // try to load FPDF
            $fpdfPath = ROOT . 'lib' . DS . 'fpdf.php';
            if (!is_readable($fpdfPath)) {
                echo "FPDF no encontrado en 'lib/fpdf.php'. Coloca fpdf.php en la carpeta lib/ para generar PDFs.";
                return;
            }

            require_once $fpdfPath;

            // load related labels (minimal, keep logic simple)
            $userName = '';
            try {
                $u = new \Models\User();
                $ru = $u->getForId($audit->user_id);
                if ($ru) $userName = isset($ru->username) ? $ru->username : (isset($ru->name) ? $ru->name : $audit->user_id);
            } catch (\Exception $e) {}

            $deskName = '';
            try {
                $d = new \Models\ServiceDesk();
                $rd = $d->getForId($audit->desk_id);
                if ($rd) $deskName = isset($rd->desk_name) ? $rd->desk_name : (isset($rd->name) ? $rd->name : $audit->desk_id);
            } catch (\Exception $e) {}

            $ticketLabel = '';
            try {
                $t = new \Models\Ticket();
                $rt = $t->getForId($audit->ticket_id);
                if ($rt) $ticketLabel = isset($rt->ticket_code) ? $rt->ticket_code : (isset($rt->title) ? $rt->title : (isset($rt->subject) ? $rt->subject : $audit->ticket_id));
            } catch (\Exception $e) {}

            // build PDF
            $pdf = new \FPDF('P','mm','A4');
            $pdf->SetMargins(15, 15, 15);
            $pdf->AddPage();

            // Add logo from Ideas/ folder if available (supported: PNG, JPG)
            $logoPathPng = ROOT . 'Ideas' . DS . 'logo.png';
            $logoPathJpg = ROOT . 'Ideas' . DS . 'logo.jpg';
            $logoPath = '';
            if (is_readable($logoPathPng)) {
                $logoPath = $logoPathPng;
            } elseif (is_readable($logoPathJpg)) {
                $logoPath = $logoPathJpg;
            }
            if (!empty($logoPath)) {
                // x=15mm (left margin), y=8mm, width=30mm (auto height)
                $pdf->Image($logoPath, 15, 8, 30);
                // move cursor down so title doesn't overlap the logo
                $pdf->Ln(12);
            }

            $pdf->SetFont('Arial','B',14);
            $pdf->Cell(0,10, utf8_decode('Reporte de Auditoría #'.$audit->id), 0, 1, 'C');
            $pdf->Ln(4);

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(40,7,'ID:',0,0);
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(0,7,utf8_decode($audit->id),0,1);

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(40,7,'Usuario:',0,0);
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(0,7,utf8_decode($userName),0,1);

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(40,7,'Desk:',0,0);
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(0,7,utf8_decode($deskName),0,1);

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(40,7,'Ticket:',0,0);
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(0,7,utf8_decode($ticketLabel),0,1);

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(40,7,'Accion:',0,0);
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(0,7,utf8_decode($audit->action),0,1);

            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(0,6,'Detalles:',0,1);
            $pdf->SetFont('Arial','',10);
            $pdf->MultiCell(0,6,utf8_decode($audit->details));

            $pdf->Ln(4);
            $pdf->SetFont('Arial','I',9);
            $pdf->Cell(0,6,'Fecha: '.utf8_decode($audit->date_time),0,1,'R');

            // force download
            $pdf->Output('D', 'auditoria_'.$audit->id.'.pdf');
            exit;
        }
    }
?>