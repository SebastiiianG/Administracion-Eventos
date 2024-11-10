<?php
if (!empty($_GET["id"])) {
    $id = $_GET["id"];
    $sql_img = $con->query("SELECT img FROM evento WHERE id_evento='$id'");

    if ($sql_img && $sql_img->num_rows > 0) {
        $current_img = $sql_img->fetch_object()->img;
        $sql = $con->query("DELETE FROM evento WHERE id_evento = '$id'");
        $current_img_path = __DIR__ . "/../imagenesEvento/" . $current_img;

        if (file_exists($current_img_path) && !empty($current_img)) {
            unlink($current_img_path);
        }

        if ($sql == 1) {
            echo "<div class='alert alert-success'>Evento eliminado correctamente</div>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'evento.php';
                    }, 2000);
                  </script>";
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar</div>";
        }
    }    
}
?>
