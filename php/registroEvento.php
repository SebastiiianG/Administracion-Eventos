<?php
include "connection.php";

if (!empty($_POST["btnregistrar"])) {
    // Verificación de campos en $_POST y del archivo en $_FILES
    if (!empty($_POST["nombre_evento"]) && !empty($_POST["descripcion"]) &&
        !empty($_POST["fecha_evento"]) && !empty($_POST["horario_evento"]) &&
        !empty($_FILES["img"]["name"]) && !empty($_POST["id_auditorio"])) {
        
        // Conexión a la base de datos
        $con = connection();
        
        // Recoge los datos del formulario
        $nombre_evento = $_POST["nombre_evento"];
        $descripcion = $_POST["descripcion"];
        $fecha_evento = $_POST["fecha_evento"];
        $horario_evento = $_POST["horario_evento"];
        $id_auditorio = $_POST["id_auditorio"];
        
        // Manejo de la imagen
        $nombreImagen = $_FILES["img"]["name"]; // Nombre original del archivo
        $rutaTemporal = $_FILES["img"]["tmp_name"]; // Ruta temporal del archivo
        $rutaDestino = "imagenesEvento/" . $nombreImagen; // Ruta donde se guardará la imagen
        
        // Mover la imagen a la carpeta "imagenesEvento"
        if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
            // Insertar en la base de datos solo la ruta relativa de la imagen
            $sql = "INSERT INTO evento (nombre_evento, descripcion, fecha_evento, horario_evento, img, id_auditorio) 
                    VALUES ('$nombre_evento', '$descripcion', '$fecha_evento', '$horario_evento', '$rutaDestino', '$id_auditorio')";

            if (mysqli_query($con, $sql)) {
                echo '<div class="alert alert-success">Evento registrado correctamente</div>';
            } else {
                echo '<div class="alert alert-danger">Error al registrar evento</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Error al mover la imagen a la carpeta de destino</div>';
        }
    } else {
        echo '<div class="alert alert-warning">Alguno de los campos está vacío</div>';
    }
}
?>
