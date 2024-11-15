<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>FAQ</title>
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
    
    <div>
        <h2>1. ¿Cómo puedo registrar un nuevo evento?</h2>
        <p>Para registrar un nuevo evento, dirígete a la página <strong>Crear un evento</strong>, completa el formulario con los detalles del evento y haz clic en "Agregar Evento". Asegúrate de llenar todos los campos requeridos.</p>

        <h2>2. ¿Por qué no puedo cargar una imagen al registrar un evento?</h2>
        <p>Revisa los siguientes puntos si tienes problemas al cargar una imagen:</p>
        <ul>
            <li>Asegúrate de que el archivo sea en formato JPG, PNG o GIF.</li>
            <li>Verifica que tu navegador tenga los permisos necesarios para acceder a los archivos locales.</li>
        </ul>

        <h2>3. ¿Cómo puedo editar o eliminar un evento?</h2>
        <p>En la tabla de eventos, encontrarás opciones para <strong>Editar</strong> o <strong>Eliminar</strong> cada evento. Haz clic en el enlace correspondiente para realizar la acción deseada.</p>
        <p>Incluso puedes generar el reporte de tu evento al consultar los detalles.</p>

        <h2>4. ¿Qué hacer si el auditorio no aparece en la lista desplegable?</h2>
        <p>Si el auditorio no aparece, puede deberse a que no ha sido registrado en el sistema. Contacta al administrador del sistema para verificar y agregar el auditorio correspondiente tambien es posible que ese auditorio no exista.</p>

        <h2>5. ¿Cómo puedo buscar eventos existentes?</h2>
        <p>En la página <strong>Buscar eventos</strong>, encontrarás una lista de todos los eventos disponibles en la semana. Sin embargo, puedes  filtrar los eventos por fecha.</p>

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