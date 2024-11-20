<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Gestor de Eventos</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/headerStyles.css">
    <link rel="stylesheet" href="../css/footerStyles.css">
    <link rel="stylesheet" href="../css/indexStyles.css">
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

    <!-- Banner Principal -->
    <section class="banner">
        <h1 styles>Gestor de eventos de la UAEH</h1>
        <p>
            El <strong>orden</strong> en la gestión, el <strong>amor</strong> en la participación, y el <strong>progreso</strong> en cada experiencia.
        </p>
        <a href="eventosDisponibles.php" class="cta-button">Consultar eventos disponibles</a>
    </section>

    <!-- Sección de Servicios -->
    <section class="services">
        <div class="service-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="white-icon">
            <path style="text-indent:0;text-align:start;line-height:normal;text-transform:none;-inkscape-font-specification:Bitstream Vera Sans" d="M 16 5 C 12.145852 5 9 8.1458513 9 12 C 9 14.408843 10.23116 16.55212 12.09375 17.8125 C 8.5266131 19.342333 6 22.881262 6 27 L 8 27 C 8 24.466863 9.1726397 22.213966 11 20.75 L 15.3125 24.71875 L 16 25.375 L 16.6875 24.71875 L 21 20.75 C 22.82736 22.213966 24 24.466863 24 27 L 26 27 C 26 22.881262 23.473387 19.342333 19.90625 17.8125 C 21.76884 16.55212 23 14.408843 23 12 C 23 8.1458513 19.854148 5 16 5 z M 16 7 C 18.773268 7 21 9.2267317 21 12 C 21 14.773268 18.773268 17 16 17 C 13.226732 17 11 14.773268 11 12 C 11 9.2267317 13.226732 7 16 7 z M 16 19 C 17.14291 19 18.236948 19.22772 19.21875 19.65625 L 16 22.65625 L 12.78125 19.65625 C 13.763052 19.22772 14.85709 19 16 19 z" overflow="visible" font-family="Bitstream Vera Sans" fill="currentColor"/>
        </svg>

            <h3>Gestión de Invitados</h3>
            <p>Administra tus listas de invitados de manera sencilla y eficaz.</p>
        </div>
        <div class="service-item">
            <svg data-name="Capa 1" id="Capa_1" viewBox="0 0 20 19.84" xmlns="http://www.w3.org/2000/svg" class = "white-icon">
                <path
                    d="M15.65,9.93a.39.39,0,0,0-.53,0l-.57.57L14,9.93a.39.39,0,0,0-.53,0,.37.37,0,0,0,0,.53L14,11l-.57.57a.37.37,0,0,0,0,.53.38.38,0,0,0,.26.11.39.39,0,0,0,.27-.11l.57-.57.57.57a.38.38,0,0,0,.26.11.4.4,0,0,0,.27-.11.39.39,0,0,0,0-.53L15.08,11l.57-.57A.39.39,0,0,0,15.65,9.93Z" fill="currentColor"/>
                <path
                    d="M9.81,13.42,8.29,15.13l-.53-.41a.37.37,0,1,0-.46.59l.8.63a.34.34,0,0,0,.23.08.36.36,0,0,0,.28-.12l1.76-2a.38.38,0,0,0,0-.53A.37.37,0,0,0,9.81,13.42Z" fill="currentColor" />
                <path
                    d="M5.33,6.7h6.19a.37.37,0,0,0,.37-.38A.36.36,0,0,0,11.52,6H5.33A.37.37,0,0,0,5,6.32.38.38,0,0,0,5.33,6.7Z" fill="currentColor"/>
                <path
                    d="M5.35,9.4H9A.38.38,0,0,0,9.38,9,.37.37,0,0,0,9,8.65H5.35A.37.37,0,0,0,5,9,.38.38,0,0,0,5.35,9.4Z" fill="currentColor"/>
                <path
                    d="M17.87,11.17A3.29,3.29,0,0,0,17,8.74a3.33,3.33,0,0,0-1.66-1V5.05a1.93,1.93,0,0,0-1.93-1.93H10.28V2.75a1.41,1.41,0,0,0-2.82,0v.37H4.05A1.93,1.93,0,0,0,2.12,5.05V16.54a1.94,1.94,0,0,0,1.93,1.93h9.36a1.94,1.94,0,0,0,1.93-1.93V14.27a3.31,3.31,0,0,0,2.53-3.1ZM8.21,2.75a.66.66,0,0,1,1.32,0v.38H8.21Zm-4.16,15a1.18,1.18,0,0,1-1.18-1.18V5.05A1.18,1.18,0,0,1,4.05,3.87H9.91l.1,0h3.4a1.18,1.18,0,0,1,1.18,1.18V7.64a2.48,2.48,0,0,0-.47,0H14a4.56,4.56,0,0,0-.53.13l-.1,0a4,4,0,0,0-.47.22l-.12.06a3,3,0,0,0-.53.4,3.3,3.3,0,0,0-1.1,2.33,2.66,2.66,0,0,0,0,.49h0l-.07,0a3.92,3.92,0,0,0-.53-.29l-.19-.08-.48-.15-.21,0a3.26,3.26,0,0,0-.7-.07,3.89,3.89,0,0,0-3.89,3.88,4.17,4.17,0,0,0,.07.71.59.59,0,0,1,0,.13,4.21,4.21,0,0,0,.2.63l.05.11a4.83,4.83,0,0,0,.3.55l0,.06a4.11,4.11,0,0,0,.42.5.94.94,0,0,0,.1.1,3.5,3.5,0,0,0,.46.39Zm4.9,0a3.14,3.14,0,1,1,3.13-3.14A3.15,3.15,0,0,1,9,17.68Zm5.64-3.29v2.15a1.18,1.18,0,0,1-1.18,1.18H11.18a3.5,3.5,0,0,0,.46-.39.94.94,0,0,0,.1-.1,4.11,4.11,0,0,0,.42-.5l0-.06a4.83,4.83,0,0,0,.3-.55l0-.11a4.21,4.21,0,0,0,.2-.63s0-.09,0-.13a3.74,3.74,0,0,0,0-1.33l.1,0a3.27,3.27,0,0,0,.51.22.73.73,0,0,0,.19.07,3.91,3.91,0,0,0,.76.14h.25Zm.32-.78h0a3.08,3.08,0,0,1-.53,0,2.83,2.83,0,0,1-.52-.08l-.06,0a2.62,2.62,0,0,1-1.88-2.08.06.06,0,0,1,0,0,2.33,2.33,0,0,1,0-.53,2.84,2.84,0,0,1,.07-.52,1,1,0,0,1,0-.1,2.58,2.58,0,0,1,.14-.39l.07-.12a3.21,3.21,0,0,1,.19-.31,2.43,2.43,0,0,1,.34-.38A1.67,1.67,0,0,1,12.89,9c.08-.06.15-.13.23-.18l.19-.09a2.06,2.06,0,0,1,.26-.12,1.66,1.66,0,0,1,.21-.06,1.34,1.34,0,0,1,.27-.07.78.78,0,0,1,.22,0,2,2,0,0,1,.35,0l.19,0,.1,0h0a2.59,2.59,0,0,1,2.2,2.7,2.63,2.63,0,0,1-2.21,2.48Z" fill="currentColor"/>
            </svg>
            <h3>Confirma tu asistencia</h3>
            <p>Aparta tu lugar para evitar quedarte sin asiento.</p>
        </div>
        <div class="service-item">
            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 96 96" class="white-icon">
                <path d="M93,92.14H3a1,1,0,0,1,0-2H93a1,1,0,0,1,0,2Z" fill="currentColor"/>
                <path d="M25.26,92.14H13.89a1,1,0,0,1-1-1V68.91a1,1,0,0,1,1-1H25.26a1,1,0,0,1,1,1V91.14A1,1,0,0,1,25.26,92.14Zm-10.37-2h9.37V69.91H14.89Z" fill = "currentColor"/><path d="M44.21,92.14H32.84a1,1,0,0,1-1-1V40.7a1,1,0,0,1,1-1H44.21a1,1,0,0,1,1,1V91.14A1,1,0,0,1,44.21,92.14Zm-10.37-2h9.37V41.7H33.84Z" fill = "currentColor" fill = "currentColor"/><path d="M63.16,92.14H51.79a1,1,0,0,1-1-1v-40a1,1,0,0,1,1-1H63.16a1,1,0,0,1,1,1v40A1,1,0,0,1,63.16,92.14Zm-10.37-2h9.37v-38H52.79Z" fill = "currentColor"/><path d="M82.11,92.14H70.74a1,1,0,0,1-1-1V26.24a1,1,0,0,1,1-1H82.11a1,1,0,0,1,1,1v64.9A1,1,0,0,1,82.11,92.14Zm-10.37-2h9.37V27.24H71.74Z" fill = "currentColor"/><path d="M60.44,27a1,1,0,0,1-.7-1.71L73.81,11.31a1,1,0,1,1,1.4,1.42l-14.07,14A1,1,0,0,1,60.44,27Z" fill = "currentColor"/><path d="M53.85,27.77a1.06,1.06,0,0,1-.51-.14L41.72,20.76a1,1,0,1,1,1-1.72l11.62,6.87a1,1,0,0,1,.35,1.37A1,1,0,0,1,53.85,27.77Z" fill = "currentColor"/><path d="M18.72,36.1a1,1,0,0,1-.76-.36,1,1,0,0,1,.12-1.41L34.9,20.16a1,1,0,0,1,1.28,1.53L19.36,35.86A1,1,0,0,1,18.72,36.1Z" fill = "currentColor"/><path d="M15.83,43.44a5.24,5.24,0,1,1,5.24-5.24A5.25,5.25,0,0,1,15.83,43.44Zm0-8.48a3.24,3.24,0,1,0,3.24,3.24A3.24,3.24,0,0,0,15.83,35Z" fill = "currentColor"/><path d="M38.5,23.13a5.25,5.25,0,1,1,5.24-5.24A5.25,5.25,0,0,1,38.5,23.13Zm0-8.49a3.25,3.25,0,1,0,3.24,3.25A3.26,3.26,0,0,0,38.5,14.64Z" fill = "currentColor"/><path d="M57.46,34.22A5.24,5.24,0,1,1,62.71,29,5.25,5.25,0,0,1,57.46,34.22Zm0-8.48A3.24,3.24,0,1,0,60.71,29,3.24,3.24,0,0,0,57.46,25.74Z" fill = "currentColor"/><path d="M77.61,14.35a5.25,5.25,0,1,1,5.24-5.24A5.25,5.25,0,0,1,77.61,14.35Zm0-8.49a3.25,3.25,0,1,0,3.24,3.25A3.26,3.26,0,0,0,77.61,5.86Z" fill="currentColor"/>
                </svg>
            <h3>Métricas del evento</h3>
            <p>Consulta cuántos asistentes tienen tus eventos y qué eventos ocurren en simuláneo con el tuyo.</p>
        </div>
    </section>

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
