    <?php

    $con = connection();

    if (!isset($_SESSION['numero_cuenta'])) {
        header("Location: login.php");
        exit();
    }

    $numero_cuenta = $_SESSION['numero_cuenta'];

    // Consulta para eventos futuros
    $sql_futuros = "
        SELECT evento.*, auditorio.capacidad, auditorio.ubicacion, 
        auditorio.nombre_auditorio, 
        asistencia.id_asistencia 
        FROM asistencia 
        JOIN evento ON asistencia.id_evento = evento.id_evento 
        JOIN auditorio ON evento.id_auditorio = auditorio.id_auditorio 
        WHERE asistencia.numero_cuenta = '$numero_cuenta' 
        AND evento.fecha_evento >= CURDATE()
        ORDER BY evento.fecha_evento, evento.horario_evento
    ";
    $resultado_futuros = mysqli_query($con, $sql_futuros);

    // Consulta para eventos pasados
    $sql_pasados = "
        SELECT evento.*, auditorio.capacidad, auditorio.ubicacion, 
        auditorio.nombre_auditorio, asistencia.id_asistencia 
        FROM asistencia 
        JOIN evento ON asistencia.id_evento = evento.id_evento 
        JOIN auditorio ON evento.id_auditorio = auditorio.id_auditorio 
        WHERE asistencia.numero_cuenta = '$numero_cuenta' 
        AND evento.fecha_evento < CURDATE()
        ORDER BY evento.fecha_evento DESC, evento.horario_evento DESC
    ";
    $resultado_pasados = mysqli_query($con, $sql_pasados);
    ?>
