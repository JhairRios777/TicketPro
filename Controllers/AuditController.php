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
            $fpdfPath = ROOT . 'Vendor' . DS . 'fpdf' . DS . 'fpdf.php';
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
            // Log that the audit report was downloaded
            try {
                $userId = isset($_SESSION["system"]["user_id"]) ? $_SESSION["system"]["user_id"] : null;
                $this->auditModel->log($userId, $audit->desk_id, $audit->ticket_id, 'download_pdf', 'Descarga de reporte de auditoría ID '.$audit->id);
            } catch (\Exception $e) {
                // ignore logging failure
            }

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

    public function Registry($id = '') {
        // If the form was submitted, save the record and redirect
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Registrar'])) {
            $entity = new \stdClass();
            $entity->id = isset($_POST['id']) && $_POST['id'] !== '' ? $_POST['id'] : $id;
            $entity->user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
            $entity->desk_id = isset($_POST['desk_id']) ? $_POST['desk_id'] : '';
            $entity->ticket_id = isset($_POST['ticket_id']) ? $_POST['ticket_id'] : '';
            $entity->action = isset($_POST['action']) ? $_POST['action'] : '';
            $entity->details = isset($_POST['details']) ? $_POST['details'] : '';
            // convert datetime-local (YYYY-MM-DDTHH:MM) to space-separated
            $dt = isset($_POST['date_time']) ? $_POST['date_time'] : '';
            if ($dt !== '') {
                $entity->date_time = str_replace('T', ' ', $dt) . ':00';
            } else {
                $entity->date_time = '';
            }

            try {
                $this->auditModel->save($entity);
            } catch (\Exception $e) {
                echo "Error guardando auditoría: " . htmlspecialchars($e->getMessage());
                exit;
            }
            echo "<script>window.location.href='/Audit';</script>";
            exit;
        }

        $result = $this->auditModel->getForId($id);
        if ($result && is_object($result)) {
            return $result;
        }

        $empty = new \stdClass();
        $empty->id = $id ?: '';
        $empty->user_id = '';
        $empty->desk_id = '';
        $empty->ticket_id = '';
        $empty->action = '';
        $empty->details = '';
        $empty->date_time = '';
        return $empty;
    }

    }
?>