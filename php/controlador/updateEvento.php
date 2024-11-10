<?php
if (!empty($_POST["btnRegistrar"])) {
    if (!empty($_POST["nombre_evento"]) && !empty($_POST["descripcion"]) &&
        !empty($_POST["fecha_evento"]) && !empty($_POST["horario_evento"]) &&
        !empty($_POST["duracion_evento"]) && !empty($_POST["id_auditorio"])) {
        
        // Recoge los datos del formulario
        $id = $_POST["id"];
        $nombre_evento = $_POST["nombre_evento"];
        $descripcion = $_POST["descripcion"];
        $fecha_evento = $_POST["fecha_evento"];
        $horario_evento = $_POST["horario_evento"];
        $duracion_evento = $_POST["duracion_evento"];
        $id_auditorio = $_POST["id_auditorio"];

        // Verifica si se subió una nueva imagen
        if (!empty($_FILES["img"]["name"])) {
            $sql_img = $con->query("SELECT img FROM evento WHERE id_evento='$id'");
            $current_img = $sql_img->fetch_object()->img;
            $current_img_path = __DIR__ . "/../imagenesEvento/" . $current_img;

            if (file_exists($current_img_path) && !empty($current_img)) {
                unlink($current_img_path);
            }

            // Manejo de la nueva imagen
            $nombreOriginal = basename($_FILES["img"]["name"]);
            $nombreImagen = uniqid() . "_" . $nombreOriginal;
            $rutaTemporal = $_FILES["img"]["tmp_name"];
            $rutaDestino = __DIR__ . "/../imagenesEvento/" . $nombreImagen;

            if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                $sql = $con->query("UPDATE evento SET 
                    nombre_evento='$nombre_evento',
                    descripcion='$descripcion', 
                    fecha_evento='$fecha_evento',
                    horario_evento='$horario_evento', 
                    duracion_evento='$duracion_evento', 
                    id_auditorio='$id_auditorio',
                    img='$nombreImagen' 
                    WHERE id_evento='$id'");
            } else {
                echo "<div class='alert alert-danger'>Error al mover la nueva imagen al directorio.</div>";
                exit();
            }
        } else {
            $sql = $con->query("UPDATE evento SET 
                nombre_evento='$nombre_evento',
                descripcion='$descripcion', 
                fecha_evento='$fecha_evento',
                horario_evento='$horario_evento', 
                duracion_evento='$duracion_evento', 
                id_auditorio='$id_auditorio'
                WHERE id_evento='$id'");
        }

        if ($sql) {
            echo "<div class='alert alert-success'>Evento modificado correctamente.</div>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'evento.php';
                    }, 2000);
                  </script>";
        } else {
            echo "<div class='alert alert-danger'>Error al modificar el evento.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Campos vacíos</div>";
    }
    mysqli_close($con);
}
