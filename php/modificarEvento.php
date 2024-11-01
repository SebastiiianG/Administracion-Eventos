<?php
include "connection.php";
$id = $_GET["id"];
$con = connection();

$sql = "SELECT evento.*, auditorio.nombre_auditorio 
        FROM evento 
        JOIN auditorio ON evento.id_auditorio = auditorio.id_auditorio
        WHERE id_evento = $id";
$modif_query = mysqli_query($con, $sql);

$auditorio_sql = "SELECT id_auditorio, nombre_auditorio FROM auditorio";
$auditorio_query = mysqli_query($con, $auditorio_sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar registro</title>
</head>
<body>
<form method="POST" enctype="multipart/form-data">
    <h5>Modificar evento</h5>
    <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
    <?php
    include "controlador/updateEvento.php";
    while ($datos = $modif_query->fetch_object()) { ?>

        <label for="nombre_evento">Nombre del Evento:</label>
        <input type="text" name="nombre_evento" value="<?= $datos->nombre_evento ?>" required>
        <br>
        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" value="<?= $datos->descripcion ?>" required>
        <br>
        <label for="fecha_evento">Fecha del Evento:</label>
        <input type="date" name="fecha_evento" value="<?= $datos->fecha_evento ?>" required>
        <br>
        <label for="horario_evento">Horario del Evento:</label>
        <input type="time" name="horario_evento" value="<?= $datos->horario_evento ?>" required>
        <br>
        <label for="duracion_evento">Duración del Evento (en minutos):</label>
        <input type="number" name="duracion_evento" value="<?= $datos->duracion_evento ?>" required min="1" step="1">
        <br>
        <!-- Imagen del Evento -->
        <label for="img">Imagen del Evento:</label>
        <br>
        <?php if (!empty($datos->img)) { ?>
            <img src="imagenesEvento/<?= $datos->img ?>" alt="Imagen actual del Evento" style="width: 100px; height: auto;">
            <br>
            <span>Sube una nueva imagen si deseas cambiarla:</span>
        <?php } ?>
        <input type="file" name="img">
        <br>

        <!-- Select de Auditorio -->
        <label for="id_auditorio">Auditorio:</label>
        <select name="id_auditorio" required>
            <?php
            while ($auditorio = $auditorio_query->fetch_assoc()) {
                $selected = ($auditorio['id_auditorio'] == $datos->id_auditorio) ? 'selected' : '';
                echo "<option value='" . $auditorio['id_auditorio'] . "' $selected>" . $auditorio['nombre_auditorio'] . "</option>";
            }
            ?>
        </select>
    <?php } ?>
    
    <br>
    <button type="submit" name="btnRegistrar" value="ok">Modificar Evento</button>
</form>
</body>
</html>
