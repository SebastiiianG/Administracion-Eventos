<!DOCTYPE html>
<html lang="es">
<head>
    <title>Registro de Evento</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/estilosCustom.css" rel="stylesheet">
</head>
<body>
    <header></header>
    <nav></nav>
    <div id="formulario">
        <?php
        session_start();
        
        // Mostrar el mensaje si existe en la sesión
        if (isset($_SESSION['mensaje'])) {
            echo $_SESSION['mensaje'];
            unset($_SESSION['mensaje']); // Eliminar el mensaje de la sesión después de mostrarlo
        }

        include "connection.php";   
        $con = connection();

        // Consulta para obtener los auditorios
        $auditorio_sql = "SELECT id_auditorio, nombre_auditorio FROM auditorio";
        $auditorio_query = mysqli_query($con, $auditorio_sql);

        // Consulta para obtener la lista de eventos
        $sql = "SELECT evento.*, auditorio.nombre_auditorio 
                FROM evento 
                JOIN auditorio ON evento.id_auditorio = auditorio.id_auditorio";
        $query = mysqli_query($con, $sql);
        ?>

        <!-- Formulario para Evento -->
        <form action="registroEvento.php" method="POST" enctype="multipart/form-data">
            <label for="nombre_evento">Nombre del Evento:</label>
            <input type="text" name="nombre_evento" required>
            <br>
            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" required>
            <br>
            <label for="fecha_evento">Fecha del Evento:</label>
            <input type="date" name="fecha_evento" required>
            <br>
            <label for="horario_evento">Horario del Evento:</label>
            <input type="time" name="horario_evento" required>
            <br>
            <label for="img">Imagen del Evento:</label>
            <input type="file" name="img" required>
            <br>
            <label for="id_auditorio">Auditorio:</label>
            <select name="id_auditorio" required>
                <?php
                while ($auditorio = $auditorio_query->fetch_assoc()) {
                    echo "<option value='" . $auditorio['id_auditorio'] . "'>" . $auditorio['nombre_auditorio'] . "</option>";
                }
                ?>
            </select>
            <br>
            <button type="submit" name="btnRegistrar" value="ok">Agregar Evento</button>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Evento</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Horario</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Auditorio</th>
                    <th scope="col"> </th>
                </tr>
            </thead>
            <tbody>
                <?php while ($datos = $query->fetch_object()) { ?>
                    <tr>
                        <td><?= $datos->nombre_evento ?></td>
                        <td><?= $datos->descripcion ?></td>
                        <td><?= $datos->fecha_evento ?></td>
                        <td><?= $datos->horario_evento ?></td>
                        <td><img src="imagenesEvento/<?= $datos->img ?>" alt="Imagen del Evento" style="width: 100px; height: auto;"></td>
                        <td><?= $datos->nombre_auditorio ?></td>
                        <td>
                            <a href="">Editar</a>
                            <a href="">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
