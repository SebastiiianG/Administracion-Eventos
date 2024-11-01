<!DOCTYPE html>
<html lang="es">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../css/estilosCustom.css" rel="stylesheet">
    </head>
    <body>
        <header></header>
        <nav></nav>
        <div id="formulario">
            <!-- Formulario para Evento -->
            <form action="registroEvento.php" method="POST" enctype="multipart/form-data">
                <?php
                include "connection.php";   
                $con = connection();

                // Consulta para obtener los auditorios
                $auditorio_sql = "SELECT id_auditorio, nombre_auditorio FROM auditorio";
                $auditorio_query = mysqli_query($con, $auditorio_sql);

                $sql = "SELECT evento.*, auditorio.nombre_auditorio 
                        FROM evento 
                        JOIN auditorio ON evento.id_auditorio = auditorio.id_auditorio";
                $query = mysqli_query($con, $sql);
                ?>
                
                <label for="nombre_evento">Nombre del Evento:</label>
                <input type="text" name="nombre_evento">
                <br>
                <label for="descripcion">Descripción:</label>
                <input type="text" name="descripcion">
                <br>
                <label for="fecha_evento">Fecha del Evento:</label>
                <input type="date" name="fecha_evento">
                <br>
                <label for="horario_evento">Horario del Evento:</label>
                <input type="time" name="horario_evento">
                <br>
                <label for="img">Imagen del Evento:</label>
                <input type="file" name="img">
                <br>
                <label for="id_auditorio">Auditorio:</label>
                <select name="id_auditorio">
                    <?php
                    while($auditorio = $auditorio_query->fetch_assoc()) {
                        echo "<option value='" . $auditorio['id_auditorio'] . "'>" . $auditorio['nombre_auditorio'] . "</option>";
                    }
                    ?>
                </select>
                <br>
                <button type="submit" name="btnregistrar" value="ok">Agregar Evento</button>
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
                <?php
                    while($datos = $query->fetch_object()) { ?>
                        <tr>
                            <td><?= $datos->nombre_evento ?></td>
                            <td><?= $datos->descripcion ?></td>
                            <td><?= $datos->fecha_evento ?></td>
                            <td><?= $datos->horario_evento ?></td>
                            <td><img src="imagenesEvento/<?= $datos->img ?>" alt="Imagen del Evento" style="width: 100px; height: auto;"></td>
                            <td><?= $datos->nombre_auditorio ?></td> <!-- Muestra el nombre del auditorio -->
                            <td>
                                <a href="">Editar</a>
                                <a href="">Eliminar</a>
                            </td>
                        </tr>
                    <?php }
                ?>
                </tbody>
            </table>

        </div>
    </body>
</html>