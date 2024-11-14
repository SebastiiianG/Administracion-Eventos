<?php
   $con = connection();

   $evento = null;
   $asistentes = [];
   $asistentes_confirmados = 0;
   $asientos_restantes = 0;
   
   // Verificar que se haya pasado un ID de evento
   if (isset($_GET['id'])) {
       $id_evento = $_GET['id'];
   
       // Consulta para obtener los datos del evento y su auditorio
       $sql_evento = "SELECT evento.id_evento, evento.nombre_evento, evento.descripcion, evento.fecha_evento, evento.horario_evento, evento.duracion_evento,
                             auditorio.nombre_auditorio, auditorio.capacidad, auditorio.ubicacion
                      FROM evento 
                      JOIN auditorio ON evento.id_auditorio = auditorio.id_auditorio
                      WHERE evento.id_evento = '$id_evento'";
       $resultado_evento = mysqli_query($con, $sql_evento);
       $evento = mysqli_fetch_assoc($resultado_evento);
   
       if ($evento) {
           // Calcular el horario de finalización del evento
           $hora_inicio = $evento['horario_evento'];
           $duracion_evento = $evento['duracion_evento'];
           $hora_fin = date("H:i:s", strtotime("+$duracion_evento minutes", strtotime($hora_inicio)));
           $evento['horario_fin'] = $hora_fin;
   
           // Obtener el número de asistentes confirmados
           $sql_asistentes_confirmados = "SELECT COUNT(*) AS confirmados FROM asistencia WHERE id_evento = '$id_evento'";
           $resultado_asistentes_confirmados = mysqli_query($con, $sql_asistentes_confirmados);
           $asistentes_confirmados_data = mysqli_fetch_assoc($resultado_asistentes_confirmados);
           $asistentes_confirmados = $asistentes_confirmados_data['confirmados'];
   
           // Calcular los asientos restantes
           $asientos_restantes = $evento['capacidad'] - $asistentes_confirmados;
   
           // Consulta para obtener la lista de asistentes al evento
           $sql_asistentes = "SELECT usuario.nombres, usuario.ap_paterno, usuario.ap_materno, usuario.numero_cuenta
                              FROM asistencia
                              JOIN usuario ON asistencia.numero_cuenta = usuario.numero_cuenta
                              WHERE asistencia.id_evento = '$id_evento'";
           $resultado_asistentes = mysqli_query($con, $sql_asistentes);
   
           // Guardar los asistentes en un array
           while ($asistente = mysqli_fetch_assoc($resultado_asistentes)) {
               $asistentes[] = $asistente;
           }
       }
   } else {
       $_SESSION['mensaje'] = "<div class='alert alert-danger'>ID de evento no especificado.</div>";
       header("Location: eventosDisponibles.php");
       exit();
   }
?>