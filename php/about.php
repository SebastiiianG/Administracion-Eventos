<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>About</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/headerStyles.css">
    <link rel="stylesheet" href="../css/footerStyles.css">
    <link rel="stylesheet" href="../css/aboutUsStyles.css">
</head>

<body>
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
                        <p><?php echo $_SESSION['nombres'] . ' ' . $_SESSION['ap_paterno'] . ' ' . $_SESSION['ap_materno']; ?>
                            (<?php echo $_SESSION['numero_cuenta']; ?>)</p>
                        <p><?php echo $_SESSION['licenciatura'] . ' ' . $_SESSION['semestre'] . '° ' . $_SESSION['grupo']; ?>
                        </p>
                        <a href="misEventos.php">Mis eventos</a>
                        <a href="controlador/logout.php">Cerrar sesión</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php">Iniciar Sesión</a>
            <?php endif; ?>
        </div>
    </header>
    <div class="parallax">
        <div class="layer" data-depth="0.2"></div>
        <div class="layer" data-depth="0.5"></div>
        <div class="layer" data-depth="1"></div>
    </div>
    <script src="../js/parallax.js"></script>
    <div id="main-content">
        <div class="about-section">
            <h2>Conócenos</h2>
            <p class="description">
                Universidad Autónoma del Estado de Hidalgo - UAEH
                <br>
                Somos un equipo de desarrollo de la Universidad Autónoma del Estado de Hidalgo, cursando el 7º grado,
                Grupo
                1.
            </p>
            <h3>Equipo de Desarrollo</h3>
            <div class="team">
                <div class="card-3d">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                        <img src="../resources/aboutUs_resources/pfpEdwin.jpeg" alt="Campos Dragusin Edwin">
                            <p>Campos Dragusin Edwin</p>
                        </div>
                        <div class="flip-card-back">
                            <p>Se centró en el desarrollo front-end de este proyecto mediante CSS y JS</p>
                        </div>
                    </div>
                </div>
                <div class="card-3d">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                        <img src="../resources/aboutUs_resources/pfpSebas.jpeg" alt="Campos Dragusin Edwin">
                            <p>García García Ulises Sebastian</p>
                        </div>
                        <div class="flip-card-back">
                            <p>Se centró en el desarrollo back-end de este proyecto mediante PHP y HTML</p>
                        </div>
                    </div>
                </div>
                <div class="card-3d">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                        <img src="../resources/aboutUs_resources/pfpEdwin.jpeg" alt="Campos Dragusin Edwin">
                            <p>García Sandoval Pedro Daniel</p>
                        </div>
                        <div class="flip-card-back">
                            <p>Se centró en la recopilación de la información y apoyó a ambos ends en el desarrollo general</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Pie de Página -->
    <footer>
        <p>&copy; 2024 Gestor de Eventos. Todos los derechos reservados.</p>
        <p>
            <a href="FAQ.php">FAQ</a>
        </p>
        <p>
             <a href="icbi.php">Instituto de Ciencias Básicas e Ingeniería</a> |
            <a href="tel:+527713038278">Teléfono</a> |
            <a href="mailto:ca465354@uaeh.edu.mx">Correo Electrónico</a>
        </p>
    </footer>
</body>

</html>