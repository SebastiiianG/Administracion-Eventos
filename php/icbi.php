<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>ICBI - Universidad Autónoma del Estado de Hidalgo</title>
    <!-- Enlaces a las hojas de estilo -->
    <link rel="stylesheet" href="../css/icbiStyles.css">
    <link rel="stylesheet" href="../css/footerStyles.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/headerStyles.css">
</head>

<body>
    <?php
    session_start();
    ?>
    <!--Script para desplegar el menú lateral-->
    <script>
        function toggleMenu() {
            const menu = document.getElementById("userMenuContent");
            menu.classList.toggle("open"); // Agrega o quita la clase 'open' para mostrar/ocultar el menú
        }

        // Cerrar el menú si se hace clic fuera de él
        window.onclick = function (event) {
            const menu = document.getElementById("userMenuContent");
            if (!event.target.matches('.menu-icon') && menu.classList.contains("open")) {
                menu.classList.remove("open");
            }
        };
    </script>

    <!-- Encabezado -->
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
            <script src="../js/linkActivo.js"></script>
        </nav>
        <div class="auth-buttons">
            <?php if (isset($_SESSION['numero_cuenta'])): ?>
                <!-- Ícono de menú desplegable lateral con información del usuario -->
                <div class="user-menu">
                    <img src="../resources/icons/menu.png" alt="Menú" class="menu-icon" onclick="toggleMenu()">
                    <div id="userMenuContent" class="user-menu-content">
                        <p><?php echo $_SESSION['nombres'] . ' ' . $_SESSION['ap_paterno'] . ' ' . $_SESSION['ap_materno']; ?> (<?php echo $_SESSION['numero_cuenta']; ?>)</p>
                        <p><?php echo $_SESSION['licenciatura'] . ' ' . $_SESSION['semestre']; ?>° <?php echo $_SESSION['grupo']; ?></p>
                        <a href="misEventos.php">Mis eventos</a>
                        <a href="controlador/logout.php">Cerrar sesión</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php">Iniciar Sesión</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Efecto Parallax -->
    <div class="parallax">
        <div class="layer" data-depth="0.2"></div>
        <div class="layer" data-depth="0.5"></div>
        <div class="layer" data-depth="1"></div>
    </div>
    <script src="../js/parallax.js"></script>

    <!-- Contenido principal -->
    <div id="main-content">
        <div class="content-container">
            <h1 class="titulo-formulario">Instituto de Ciencias Básicas e Ingeniería (ICBI)</h1>
            
                    <section id="sobre-icbi" class="info-section">
                        <h2 class="subtitulo-formulario">Sobre el ICBI</h2>
                        <p>
                            El Instituto de Ciencias Básicas e Ingeniería (ICBI) es una de las instituciones académicas más destacadas de la Universidad Autónoma del Estado de Hidalgo. Se dedica a la formación de profesionales en áreas científicas y tecnológicas, fomentando la investigación y la innovación para contribuir al desarrollo regional y nacional.
                        </p>
                    </section>
            
                    <section id="carreras" class="info-section">
                        <h2 class="subtitulo-formulario">Carreras Ofrecidas</h2>
                        <ul class="lista-carreras">
                            <li>Ingeniería Civil</li>
                            <li>Ingeniería Electrónica</li>
                            <li>Ingeniería Industrial</li>
                            <li>Ingeniería en Sistemas Computacionales</li>
                            <li>Ingeniería Mecánica</li>
                            <li>Ingeniería en Geología Ambiental</li>
                            <li>Licenciatura en Matemáticas Aplicadas</li>
                            <li>Licenciatura en Química</li>
                            <li>Entre otras</li>
                        </ul>
                    </section>
            
                    <section id="ubicacion" class="info-section">
                        <h2 class="subtitulo-formulario">Ubicación</h2>
                        <p>
                            El ICBI se encuentra ubicado en la Ciudad del Conocimiento de la UAEH, en Mineral de la Reforma, Hidalgo. Su campus ofrece instalaciones modernas y equipadas para brindar una educación de calidad.
                        </p>
                        <div class="map-container">
                            <!-- Mapa actualizado con la dirección real del ICBI -->
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3763.7854037252067!2d-98.93855768468398!3d20.091482126401962!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1a5e999fcc3d3%3A0x9e6726b7d7dceec1!2sInstituto%20de%20Ciencias%20B%C3%A1sicas%20e%20Ingenier%C3%ADa!5e0!3m2!1ses-419!2smx!4v1698540000000!5m2!1ses-419!2smx" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </section>
            
                    <section id="contacto" class="info-section">
                        <h2 class="subtitulo-formulario">Contacto</h2>
                        <p><strong>Dirección:</strong> Ciudad Universitaria, Carretera Pachuca - Tulancingo Km. 4.5, Mineral de la Reforma, Hidalgo, México.</p>
                        <p><strong>Teléfono:</strong> <a href="tel:+527717172000" class="enlace-evento">+52 (771) 717 2000</a></p>
                        <p><strong>Sitio web:</strong> <a href="https://www.uaeh.edu.mx/icbi/" target="_blank" class="enlace-evento">www.uaeh.edu.mx/icbi/</a></p>
                    </section>
        </div>
    </div>

    <!-- Pie de página -->
    <footer>
        <p>&copy; 2024 Gestor de Eventos. Todos los derechos reservados.</p>
        <p>
            <a href="FAQ.php">FAQ</a>
        </p>
        <p>
            <a href="icbi.php">Instituto de Ciencias Básicas e Ingeniería</a> |
            <a href="tel:+527717172000">Teléfono</a> |
            <a href="mailto:contacto@uaeh.edu.mx">Correo Electrónico</a>
        </p>
    </footer>
</body>

</html>
