<?php
require_once('fpdf.php');
require_once('../connection.php');

set_time_limit(0); // Permite ejecución indefinida
ini_set('memory_limit', '512M'); // Incrementa límite de memoria

ob_start(); // Inicia el buffer de salida

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        global $con; // Usa la conexión global
        $id = isset($_GET["id"]) ? $_GET["id"] : null;

        if ($id) {
            $consulta_evento = $con->query("SELECT evento.nombre_evento, evento.fecha_evento, auditorio.nombre_auditorio, auditorio.capacidad, COUNT(asistencia.numero_cuenta) AS total_asistentes 
                                            FROM evento 
                                            JOIN auditorio ON evento.id_auditorio = auditorio.id_auditorio 
                                            LEFT JOIN asistencia ON asistencia.id_evento = evento.id_evento 
                                            WHERE evento.id_evento = '$id'");
            $evento_info = $consulta_evento->fetch_object();
        }

        // Imágenes de la cabecera
        $this->Image('uaeh.png', 10, 10, 30);
        $this->Image('garza.png', 180, 5, 15);

        // Título del evento
        $this->SetFont('Arial', 'B', 19);
        $this->SetTextColor(0, 0, 0);
        $this->Ln(10);
        if ($evento_info) {
            $this->Cell(0, 15, mb_convert_encoding($evento_info->nombre_evento, 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        } else {
            $this->Cell(0, 15, 'Evento no encontrado', 0, 1, 'C');
        }
        $this->Ln(5);

        // Información del auditorio
        if ($evento_info) {
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(10);
            $this->Cell(110, 10, mb_convert_encoding("Auditorio: " . $evento_info->nombre_auditorio, 'ISO-8859-1', 'UTF-8'), 0, 0, '', 0);
            $this->Ln(0);

            $this->Cell(140);
            $this->Cell(59, 10, mb_convert_encoding("Fecha: " . $evento_info->fecha_evento, 'ISO-8859-1', 'UTF-8'), 0, 0, '', 0);
            $this->Ln(5);

            $this->Cell(10);
            $this->Cell(59, 10, mb_convert_encoding("Capacidad: " . $evento_info->capacidad, 'ISO-8859-1', 'UTF-8'), 0, 0, '', 0);
            $this->Ln(10);
        }

        // Título de la tabla
        $this->SetTextColor(132, 24, 22);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, mb_convert_encoding("LISTA DE ASISTENTES", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->Ln(7);

        // Encabezados de la tabla (Repetidos en cada página)
        $this->SetFillColor(232, 100, 28);
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(15, 10, mb_convert_encoding('N°', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', 1);
        $this->Cell(85, 10, mb_convert_encoding('NOMBRE', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', 1);
        $this->Cell(30, 10, mb_convert_encoding('NO. CUENTA', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', 1);
        $this->Cell(55, 10, mb_convert_encoding('FIRMA DE ASISTENCIA', 'ISO-8859-1', 'UTF-8'), 1, 1, 'C', 1);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, mb_convert_encoding('Página ' . $this->PageNo() . '/{nb}', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    }
}

$con = connection();
$pdf = new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(0, 0, 0);

$id = isset($_GET["id"]) ? $_GET["id"] : null;

if ($id) {
    $consulta_asistentes = $con->query("SELECT usuario.nombres, usuario.ap_paterno, usuario.ap_materno, usuario.numero_cuenta 
                                        FROM asistencia 
                                        JOIN usuario ON asistencia.numero_cuenta = usuario.numero_cuenta 
                                        WHERE asistencia.id_evento = '$id' 
                                        ORDER BY usuario.numero_cuenta ASC");
    $nameEvento = $con -> query("SELECT evento.nombre_evento FROM evento
                                        WHERE evento.id_evento = '$id'");
    $datoNombre = $nameEvento->fetch_object();

    $i = 0;
    while ($datos_reporte = $consulta_asistentes->fetch_object()) {
        $i++;
        $nombre_completo = $datos_reporte->ap_paterno . " " . $datos_reporte->ap_materno . " " . $datos_reporte->nombres;

        // Salto de página dinámico
        if ($pdf->GetY() > 270) {
            $pdf->AddPage();
        }

        // Filas de la tabla
        $pdf->Cell(15, 10, mb_convert_encoding($i, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', 0);
        $pdf->Cell(85, 10, mb_convert_encoding($nombre_completo, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', 0);
        $pdf->Cell(30, 10, mb_convert_encoding($datos_reporte->numero_cuenta, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', 0);
        $pdf->Cell(55, 10, " ", 1, 1, 'C', 0);
    }
}

ob_end_clean(); // Limpia el buffer de salida antes de generar el PDF
$nombreArchivo = 'ListaInvitados_' . (isset($datoNombre->nombre_evento) ? mb_convert_encoding($datoNombre->nombre_evento, 'ISO-8859-1', 'UTF-8') : 'Evento') . '.pdf';
$pdf->Output($nombreArchivo, 'I');
?>
