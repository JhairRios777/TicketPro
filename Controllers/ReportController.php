<?php
namespace Controllers;

// Incluir los modelos necesarios
use Models\User as UserModel;
use Models\Service as ServiceModel;
use Models\Role as RoleModel;


// 1. INCLUSIÓN DE LA CLASE PERSONALIZADA (CustomPDF)
require_once(ROOT . 'Lib' . DS . 'CustomPDF.php');

use \CustomPDF;

class ReportController {
    
    private $userModel;
    private $serviceModel;
    private $roleModel;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->serviceModel = new ServiceModel();
        $this->roleModel = new RoleModel();
    }

    /**
     * Genera el reporte en PDF de todos los usuarios.
     */
    public function UserReport() {
        // 1. Obtener datos del Modelo
        // Nota: Asegúrate de que toList() devuelva un array de objetos o arrays
        $datosUsuarios = $this->userModel->toList();

        // 2. OBTENER Y CREAR MAPAS DE TRADUCCIÓN
        $serviceMap = $this->createMap($this->serviceModel->toList());
        $roleMap = $this->createMap($this->roleModel->toList());
        
        // 3. Inicializar el PDF usando tu clase personalizada
        $pdf = new \CustomPDF(); 
        $pdf->AliasNbPages(); // Habilita el conteo total de páginas {nb}
        
        // 4. Configurar el título (será usado en el Header)
        $pdf->setReporteTitulo('REPORTE DETALLADO DE USUARIOS DEL SISTEMA');
        
        // 5. Agregar la primera página (esto llama a Header() y Footer() automáticamente)
        $pdf->AddPage(); 
        
        // 6. Dibujar la tabla de datos
        $this->dibujarTablaUsuarios($pdf, $datosUsuarios, $serviceMap, $roleMap);
        
        // 7. Salida del PDF (Mostrar en el navegador)
        // Puedes cambiar 'I' por 'D' si deseas que se descargue
        $pdf->Output('I', 'Reporte_Usuarios.pdf');
    }

    // MÉTODO AUXILIAR para crear los mapas ID => Nombre
    private function createMap($list) {
        $map = [];
        if (!empty($list)) {
            foreach ($list as $item) {
                // Asume que los objetos/arrays tienen propiedades 'id' y 'name'
                $map[$item->id] = $item->name; 
            }
        }
        return $map;
    }
    
    /**
     * Lógica para dibujar la tabla de usuarios en el PDF.
     * @param CustomPDF $pdf La instancia del PDF.
     * @param array $datos Los datos obtenidos del Modelo.
     */
    private function dibujarTablaUsuarios(CustomPDF $pdf, $datos, $serviceMap, $roleMap) {

        $titulos = ['ID', 'USUARIO', 'NOMBRE COMPLETO', 'CORREO', 'TELEFONO', 'SERVICIO', 'ROL', 'ESTADO'];
        $anchos = [7, 22, 35, 30, 20, 30, 20, 16]; // Suma: 190mm (tamaño de la página A4)
        
        // Llama al método estandarizado para dibujar el encabezado de la tabla
        $pdf->TablaHeader($titulos, $anchos);
        
        $fill = false;
        foreach ($datos as $row) {
            $pdf->SetX(15);

            $serviceName = isset($serviceMap[$row->service_id]) ? $serviceMap[$row->service_id] : 'N/A';
            $roleName = isset($roleMap[$row->role_id]) ? $roleMap[$row->role_id] : 'N/A';

            // Define los valores RGB para la fila actual
            $r = $fill ? 255 : 255;
            $g = $fill ? 235 : 255;
            $b = $fill ? 230 : 255;
            
            // Aplica el color
            $pdf->SetFillColor($r, $g, $b);
            
            // Usamos iconv para convertir de UTF-8 (BD) a ISO-8859-1 (FPDF)
            $pdf->Cell($anchos[0], 6, $row->id, 'LR', 0, 'C', true);
            $pdf->Cell($anchos[1], 6, iconv('UTF-8', 'windows-1252', $row->username), 'LR', 0, 'L', true);
            $pdf->Cell($anchos[2], 6, iconv('UTF-8', 'windows-1252', $row->name), 'LR', 0, 'L', true);
            $pdf->Cell($anchos[3], 6, iconv('UTF-8', 'windows-1252', $row->email), 'LR', 0, 'L', true);
            $pdf->Cell($anchos[4], 6, iconv('UTF-8', 'windows-1252', $row->phone), 'LR', 0, 'L', true);
            $pdf->Cell($anchos[5], 6, iconv('UTF-8', 'windows-1252', $serviceName), 'LR', 0, 'L', true);
            $pdf->Cell($anchos[6], 6, iconv('UTF-8', 'windows-1252', $roleName), 'LR', 0, 'L', true);
            $pdf->Cell($anchos[7], 6, iconv('UTF-8', 'windows-1252', $row->status), 'LR', 0, 'L', true);
            
            $pdf->Ln();
            $fill = !$fill; // Cambia el color para la siguiente fila
            
        }
        // Dibuja la línea de cierre de la tabla
        $pdf->SetX(15);
        $pdf->Cell(array_sum($anchos), 0, '', 'T'); 
    }

    // Aquí iría ReporteProductos(), ReporteOrdenes(), etc.
}
?>