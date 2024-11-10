<?php
session_start();
include "connection.php";
include "controlador/controladorDisponibles.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Eventos Disponibles</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/headerStyles.css">
    <link rel="stylesheet" href="../css/footerStyles.css">
</head>
<body>
    <header>
        <div class="logo">Universidad Autónoma del Estado de Hidalgo</div>
        <nav>
            <ul>
                <li><a href="index.php" class="nav-link">Inicio</a></li>
                <li><a href="busqueda.php" class="nav-link">Buscar eventos</a></li>
                <?php if (isset($_SESSION['administrador']) && $_SESSION['administrador'] == 1): ?>
                    <li><a href="evento.php" class="nav-link">Crear un evento</a></li>
                <?php endif; ?>
                <li><a href="about.php" class="nav-link">Sobre Nosotros</a></li>
                <li><a href="contacto.php" class="nav-link">Contacto</a></li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <?php if (isset($_SESSION['numero_cuenta'])): ?>
                <a href="controlador/logout.php">Cerrar Sesión</a>
            <?php else: ?>
                <a href="login.php">Iniciar Sesión</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="filter-container">
        <form method="GET" action="">
            <label for="fecha_inicio">Desde:</label>
            <input type="date" name="fecha_inicio" value="<?php echo isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : ''; ?>" required>
            
            <label for="fecha_fin">Hasta:</label>
            <input type="date" name="fecha_fin" value="<?php echo isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : ''; ?>" required>
            
            <button type="submit">Filtrar</button>
        </form>
    </div>

    <div class="eventos-disponibles">
        <h2>Eventos Disponibles Entre las Fechas Seleccionadas</h2>
        
        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <?php while ($evento = mysqli_fetch_assoc($resultado)): ?>
                <div class="evento-item">
                    <?php
                    // Verificar si el evento actual coincide con el evento de la confirmación
                    if (isset($_GET['evento_id']) && $_GET['evento_id'] == $evento['id_evento'] && isset($_SESSION['mensaje'])) {
                        echo $_SESSION['mensaje'];
                        unset($_SESSION['mensaje']); // Eliminar el mensaje de la sesión después de mostrarlo
                    }
                    ?>
                    <h3><?php echo $evento['nombre_evento']; ?></h3>
                    <img src="imagenesEvento/<?php echo $evento['img']; ?>" alt="Imagen del evento" style="width: 200px; height: auto;">
                    <p><strong>Fecha:</strong> <?php echo $evento['fecha_evento']; ?></p>
                    <p><strong>Horario:</strong> <?php echo $evento['horario_evento']; ?></p>
                    <p><strong>Duración:</strong> <?php echo $evento['duracion_evento']; ?> minutos</p>
                    <p><strong>Descripción:</strong> <?php echo $evento['descripcion']; ?></p>
                    <p><strong>Capacidad del Auditorio:</strong> <?php echo $evento['capacidad']; ?></p>
                    <p><strong>Asientos Disponibles:</strong> <?php echo $evento['asientos_disponibles']; ?></p>
                </div>
                <?php if (isset($_SESSION['numero_cuenta'])): ?>
                    <?php
                    $id_evento = $evento['id_evento'];
                    $numero_cuenta = $_SESSION['numero_cuenta'];
                    $query_check = "SELECT * FROM asistencia WHERE id_evento = '$id_evento' AND numero_cuenta = '$numero_cuenta'";
                    $check_result = mysqli_query($con, $query_check);
                    $asistido = mysqli_num_rows($check_result) > 0;
                    ?>
                    
                    <form method="POST" action="controlador/confirmarAsistencia.php">
                        <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento']; ?>">
                        <?php if ($asistido): ?>
                            <button type="submit" name="accion" value="desconfirmar">Desconfirmar asistencia</button>
                        <?php else: ?>
                            <button type="submit" name="accion" value="confirmar">Confirmar asistencia</button>
                        <?php endif; ?>
                    </form>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay eventos programados para el rango de fechas seleccionado.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2024 Gestor de Eventos. Todos los derechos reservados.</p>
        <p><a href="FAQ.php">FAQ</a></p>
        <p><a href="#">Instituto de Ciencias Básicas e Ingeniería</a> | <a href="tel:+527713038278">Teléfono</a> | <a href="mailto:ca465354@uaeh.edu.mx">Correo Electrónico</a></p>
    </footer>
</body>
</html>
