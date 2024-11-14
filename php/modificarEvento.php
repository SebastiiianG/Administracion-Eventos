<?php
session_start();
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
    <title>Editar evento</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/headerStyles.css">
    <link rel="stylesheet" href="../css/footerStyles.css">
    <link rel="stylesheet" href="../css/modificarEvento.css">

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
                        <p><?php echo $_SESSION['licenciatura'] . ' ' . $_SESSION['semestre'] . '° ' . $_SESSION['grupo']; ?></p>
                        <a href="misEventos.php">Mis eventos</a>
                        <a href="controlador/logout.php">Cerrar sesión</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php">Iniciar Sesión</a>
            <?php endif; ?>
        </div>
    </header>

    <!--<button type="button" onclick="window.location.href='evento.php'"></button>-->
    <div>
        <a href="evento.php" class="back-link">Regresar</a>
    </div>
        
    <form method="POST" enctype="multipart/form-data" class="form-container">
        <h5 class="form-header">Modificar evento</h5>
        <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
        <?php
        include "controlador/updateEvento.php";
        while ($datos = $modif_query->fetch_object()) { ?>

            <label for="nombre_evento" class="form-label">Nombre del Evento:</label>
            <input type="text" name="nombre_evento" value="<?= $datos->nombre_evento ?>" required class="form-input">
            
            <label for="descripcion" class="form-label">Descripción:</label>
            <input type="text" name="descripcion" value="<?= $datos->descripcion ?>" required class="form-input">
            
            <label for="fecha_evento" class="form-label">Fecha del Evento:</label>
            <input type="date" name="fecha_evento" value="<?= $datos->fecha_evento ?>" required class="form-input">
            
            <label for="horario_evento" class="form-label">Horario del Evento:</label>
            <input type="time" name="horario_evento" value="<?= $datos->horario_evento ?>" required class="form-input">
            
            <label for="duracion_evento" class="form-label">Duración del Evento (en minutos):</label>
            <input type="number" name="duracion_evento" value="<?= $datos->duracion_evento ?>" required min="1" step="1" class="form-input">
            
            <label for="img" class="form-label">Imagen del Evento:</label>
            
            <?php if (!empty($datos->img)) { ?>
                <img src="imagenesEvento/<?= $datos->img ?>" alt="Imagen actual del Evento" class="event-image">
                <span class="image-instruction">Sube una nueva imagen si deseas cambiarla:</span>
            <?php } ?>
            
            <input type="file" name="img" class="form-file-input">
            
            <label for="id_auditorio" class="form-label">Auditorio:</label>
            <select name="id_auditorio" required class="form-select">
                <?php
                while ($auditorio = $auditorio_query->fetch_assoc()) {
                    $selected = ($auditorio['id_auditorio'] == $datos->id_auditorio) ? 'selected' : '';
                    echo "<option value='" . $auditorio['id_auditorio'] . "' $selected>" . $auditorio['nombre_auditorio'] . "</option>";
                }
                ?>
            </select>
        <?php } ?>
        
        <button type="submit" name="btnRegistrar" value="ok" class="submit-button">Modificar Evento</button>
    </form>
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
