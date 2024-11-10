<?php
session_start();
include "../connection.php"; 
$con = connection();

if (isset($_POST['id_evento'], $_POST['accion'], $_SESSION['numero_cuenta'])) {
    $id_evento = $_POST['id_evento'];
    $numero_cuenta = $_SESSION['numero_cuenta'];

    if ($_POST['accion'] === 'confirmar') {
        // Confirmar asistencia
        $sql_confirmar = "INSERT INTO asistencia (id_evento, numero_cuenta) VALUES ('$id_evento', '$numero_cuenta')";
        if (mysqli_query($con, $sql_confirmar)) {
            $_SESSION['mensaje'] = "<div class='alert alert-success'>Asistencia confirmada.</div>";
        } else {
            $_SESSION['mensaje'] = "<div class='alert alert-danger'>Error al confirmar asistencia.</div>";
        }
    } elseif ($_POST['accion'] === 'desconfirmar') {
        // Desconfirmar asistencia
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
