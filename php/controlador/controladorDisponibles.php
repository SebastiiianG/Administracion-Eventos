<?php
// Obtener la conexión desde la vista
$con = connection();

// Verificar si se ha enviado el rango de fechas
$fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-d');
$fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-d', strtotime('+7 days'));

// Debugging: Imprimir fechas de inicio y fin
//echo "Fecha inicio: $fecha_inicio <br>";
//echo "Fecha fin: $fecha_fin <br>";

// Consulta de eventos dentro del rango de fechas especificado
$sql = "SELECT evento.*, auditorio.capacidad, auditorio.ubicacion, auditorio.nombre_auditorio, 
            (auditorio.capacidad - IFNULL((SELECT COUNT(*) FROM asistencia WHERE asistencia.id_evento = evento.id_evento), 0)) AS asientos_disponibles 
        FROM evento 
        JOIN auditorio ON evento.id_auditorio = auditorio.id_auditorio 
        WHERE DATE(fecha_evento) BETWEEN '$fecha_inicio' AND '$fecha_fin'";

$resultado = mysqli_query($con, $sql);

// Debugging: Verificar cantidad de eventos encontrados
/*if (mysqli_num_rows($resultado) > 0) {
    echo "Eventos encontrados: " . mysqli_num_rows($resultado) . "<br>";
} else {
    echo "No se encontraron eventos en el rango de fechas.<br>";
}*/
?>
