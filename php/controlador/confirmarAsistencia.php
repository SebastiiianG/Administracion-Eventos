<?php
session_start();
include "../connection.php"; 
$con = connection();

if (isset($_POST['id_evento'], $_POST['accion'], $_SESSION['numero_cuenta'])) {
    $id_evento = $_POST['id_evento'];
    $numero_cuenta = $_SESSION['numero_cuenta'];

    if ($_POST['accion'] === 'confirmar') {
        // Obtener la fecha, hora de inicio y duración del evento actual
        $sql_evento = "SELECT fecha_evento, horario_evento, duracion_evento FROM evento WHERE id_evento = '$id_evento'";
        $resultado_evento = mysqli_query($con, $sql_evento);
        $evento = mysqli_fetch_assoc($resultado_evento);

        if ($evento) {
            $fecha_evento = $evento['fecha_evento'];
            $hora_inicio = $evento['horario_evento'];
            $duracion_evento = $evento['duracion_evento'];

            // Calcular la hora de finalización del evento
            $hora_fin = date("H:i:s", strtotime("+$duracion_evento minutes", strtotime($hora_inicio)));

            // Verificar si ya existe un evento confirmado en conflicto (misma fecha, y horarios que se solapen)
            $sql_conflicto = "
                SELECT * FROM asistencia 
                JOIN evento ON asistencia.id_evento = evento.id_evento
                WHERE asistencia.numero_cuenta = '$numero_cuenta'
                AND evento.fecha_evento = '$fecha_evento'
                AND (
                    (evento.horario_evento <= '$hora_inicio' AND DATE_ADD(evento.horario_evento, INTERVAL evento.duracion_evento MINUTE) > '$hora_inicio') OR
                    (evento.horario_evento < '$hora_fin' AND DATE_ADD(evento.horario_evento, INTERVAL evento.duracion_evento MINUTE) >= '$hora_fin')
                )
                AND asistencia.id_evento != '$id_evento'"; // Excluir el evento actual
            $resultado_conflicto = mysqli_query($con, $sql_conflicto);

            if (mysqli_num_rows($resultado_conflicto) > 0) {
                // Si hay un conflicto, mostrar mensaje de error
                $_SESSION['mensaje'] = "<div class='alert alert-danger'>No puedes confirmar este evento porque ya tienes otro en el mismo rango de horario.</div>";
                header("Location: ../eventosDisponibles.php?evento_id=$id_evento");
                exit();
            }
        }

        // Confirmar asistencia si no hay conflicto
        $sql_confirmar = "INSERT INTO asistencia (id_evento, numero_cuenta) VALUES ('$id_evento', '$numero_cuenta')";
        if (mysqli_query($con, $sql_confirmar)) {
            $_SESSION['mensaje'] = "<div class='alert alert-success'>Asistencia confirmada.</div>";
        } else {
            $_SESSION['mensaje'] = "<div class='alert alert-danger'>Error al confirmar asistencia.</div>";
        }
    } elseif ($_POST['accion'] === 'desconfirmar') {
        // Desconfirmar asistencia (sin verificación de conflicto)
        $sql_desconfirmar = "DELETE FROM asistencia WHERE id_evento = '$id_evento' AND numero_cuenta = '$numero_cuenta'";
        if (mysqli_query($con, $sql_desconfirmar)) {
            $_SESSION['mensaje'] = "<div class='alert alert-warning'>Asistencia desconfirmada.</div>";
        } else {
            $_SESSION['mensaje'] = "<div class='alert alert-danger'>Error al desconfirmar asistencia.</div>";
        }
    }

    // Redirigir a la lista de eventos con el ID del evento
    header("Location: ../eventosDisponibles.php?evento_id=$id_evento");
    exit();
}
?>
