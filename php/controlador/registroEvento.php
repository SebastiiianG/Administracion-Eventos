<?php
    session_start();
    /*Las sesiones son una forma sencilla de 
    almacenar datos para usuarios de manera 
    individual usando un ID de sesión único. 
    - Al usar  sesiones, el mensaje se almacena de manera segura en el servidor 
    y no depende de la URL o de los datos
    - Permiten separar la lógica de registro y validación*/ 
    include "../connection.php";
    if (!empty($_POST["btnRegistrar"])) {
        // Verificación de campos en $_POST y del archivo en $_FILES
        if (!empty($_POST["nombre_evento"]) && !empty($_POST["descripcion"]) &&
            !empty($_POST["fecha_evento"]) && !empty($_POST["horario_evento"]) &&
            !empty($_POST["duracion_evento"]) &&
            !empty($_FILES["img"]["name"]) && !empty($_POST["id_auditorio"])) {
            
            // Conexión a la base de datos
            $con = connection();
            
            // Recoge los datos del formulario
            $nombre_evento = $_POST["nombre_evento"];
            $descripcion = $_POST["descripcion"];
            $fecha_evento = $_POST["fecha_evento"];
            $horario_evento = $_POST["horario_evento"];
            $duracion_evento = $_POST["duracion_evento"];
            $id_auditorio = $_POST["id_auditorio"];
            
            // Validación de conflicto en fecha, hora, duración y auditorio
            $conflicto_sql = "SELECT * FROM evento 
                            WHERE fecha_evento = '$fecha_evento' 
                            AND id_auditorio = '$id_auditorio'
                            AND (
                                (horario_evento <= '$horario_evento' 
                                AND DATE_ADD(horario_evento, INTERVAL duracion_evento - 1 MINUTE) > '$horario_evento') OR
                                ('$horario_evento' < DATE_ADD(horario_evento, INTERVAL duracion_evento - 1 MINUTE)
                                AND DATE_ADD('$horario_evento', INTERVAL $duracion_evento - 1 MINUTE) > horario_evento)
                            )";
            $conflicto_query = mysqli_query($con, $conflicto_sql);

            if (mysqli_num_rows($conflicto_query) > 0) {
                $_SESSION['mensaje'] = '<div class="alert alert-warning">Ya existe un evento programado en este auditorio durante el tiempo seleccionado.</div>';
            } else {
                // Manejo de la imagen
                $nombreOriginal = basename($_FILES["img"]["name"]); // Nombre original del archivo
                $nombreImagen = uniqid() . "_" . $nombreOriginal; // Nombre único para evitar sobrescritura
                $rutaTemporal = $_FILES["img"]["tmp_name"]; // Ruta temporal del archivo
                $rutaDestino = __DIR__ . "/../imagenesEvento/" . $nombreImagen; // Ruta absoluta donde se guardará la imagen

                // Mover la imagen a la carpeta "imagenesEvento"
                if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                    // Guarda solo el nombre de la imagen en la base de datos
                    $sql = "INSERT INTO evento (nombre_evento, descripcion, fecha_evento, horario_evento, duracion_evento, img, id_auditorio) 
                            VALUES ('$nombre_evento', '$descripcion', '$fecha_evento', '$horario_evento', '$duracion_evento', '$nombreImagen', '$id_auditorio')";

                    if (mysqli_query($con, $sql)) {
                        $_SESSION['mensaje'] = '<div class="alert alert-success">Evento registrado correctamente</div>';
                    } else {
                        $_SESSION['mensaje'] = '<div class="alert alert-danger">Error al registrar evento: ' . mysqli_error($con) . '</div>';
                    }
                } else {
                    $_SESSION['mensaje'] = '<div class="alert alert-danger">Error al mover la imagen a la carpeta de destino</div>';
                }
            }
        } else {
            $_SESSION['mensaje'] = '<div class="alert alert-warning">Alguno de los campos está vacío</div>';
        }

        // Cerrar la conexión a la base de datos
        mysqli_close($con);

        // Redireccionar de vuelta a index.php para mostrar el mensaje
        header("Location:../index.php"); 
        exit();
    }
?>