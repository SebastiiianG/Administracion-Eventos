<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Registrar Evento</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/headerStyles.css">
    <link rel="stylesheet" href="../css/footerStyles.css">
    
</head>
<body>
    <!--Script para desplegar el menú lateral-->
    <script>
        function toggleMenu() {
            const menu = document.getElementById("userMenuContent");
            menu.classList.toggle("open"); // Agrega o quita la clase 'open' para mostrar/ocultar el menú
        }

        // Cerrar el menú si se hace clic fuera de él
        window.onclick = function(event) {
            const menu = document.getElementById("userMenuContent");
            if (!event.target.matches('.menu-icon') && menu.classList.contains("open")) {
                menu.classList.remove("open");
            }
        };
    </script>
    <header>
        <div class="logo">Universidad Autónoma del Estado de Hidalgo</div>
        <nav>
            <ul>
                <li><a href="index.php" class="nav-link">Inicio</a></li>
                <li><a href="eventosDisponibles.php" class="nav-link">Buscar eventos</a></li>

                <!-- Verificación del rol de administrador -->
                <?php if (isset($_SESSION['administrador']) && $_SESSION['administrador'] == 1): ?>
                    <li><a href="evento.php" class="nav-link">Crear un evento</a></li>
                <?php endif; ?>

                <li><a href="about.php" class="nav-link">Sobre Nosotros</a></li>
                <li><a href="contacto.php" class="nav-link">Contacto</a></li>
            </ul>
            <script src ="../js/linkActivo.js"></script>
        </nav>
        <div class="auth-buttons">
            <?php if (isset($_SESSION['numero_cuenta'])): ?>
                <!-- Ícono de menú desplegable lateral con información del usuario -->
                <div class="user-menu">
                    <img src="../resources/icons/menu.png" alt="Menú" class="menu-icon" onclick="toggleMenu()">
                    <div id="userMenuContent" class="user-menu-content">
                        <p><?php echo $_SESSION['nombres'] . ' ' . $_SESSION['ap_paterno'] . ' ' . $_SESSION['ap_materno']; ?> (<?php echo $_SESSION['numero_cuenta']; ?>)</p>
                        <a href="misEventos.php">Mis eventos</a>
                        <a href="controlador/logout.php">Cerrar sesión</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php">Iniciar Sesión</a>
            <?php endif; ?>
        </div>
    </header>
    <script>
        function eliminar(){
            var respuesta = confirm("¿Estás seguro de que deseas eliminar este registro?");
            return respuesta;
        }
    </script>
    <nav></nav>
    <div id="formulario">
        <?php
        
        
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
        <form action="controlador/registroEvento.php" method="POST" enctype="multipart/form-data">
            <h5>Registro Evento</h5>
            <?php
                include "controlador/deleteEvento.php";
            ?>
            <br>
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
            <label for="duracion_evento">Duración del Evento (en minutos):</label>
            <input type="number" name="duracion_evento" required min="1" step="1">
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
                    <th scope="col">Duración</th>
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
                        <td><?= $datos->duracion_evento ?></td>
                        <td><img src="imagenesEvento/<?= $datos->img ?>" alt="Imagen del Evento" style="width: 100px; height: auto;"></td>
                        <td><?= $datos->nombre_auditorio ?></td>
                        <td>
                            <a href="modificarEvento.php?id=<?= $datos->id_evento ?>">Editar</a>
                            <a onclick="return eliminar()" href="evento.php?id=<?= $datos->id_evento ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- Pie de Página -->
    <footer>
        <p>&copy; 2024 Gestor de Eventos. Todos los derechos reservados.</p>
        <p>
            <a href="FAQ.php">FAQ</a>
        </p>
        <p>
            <a href="#">Instituto de Ciencias Básicas e Ingeniería</a> |
            <a href="tel:+527713038278">Teléfono</a> |
            <a href="mailto:ca465354@uaeh.edu.mx">Correo Electrónico</a>
        </p>    
    </footer> 
    
</body>
</html>
