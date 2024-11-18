<?php
session_start();
include "connection.php";
include "controlador/detallesEventoControlador.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Detalles del evento</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/headerStyles.css">
    <link rel="stylesheet" href="../css/footerStyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/detallesEventoStyles.css">
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
                        <<p><?php echo $_SESSION['nombres'] . ' ' . $_SESSION['ap_paterno'] . ' ' . $_SESSION['ap_materno']; ?>
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

    <!--<button type="button" onclick="window.location.href='evento.php'">Regresar</button>-->
    <div class="parallax">
        <div class="layer" data-depth="0.2"></div>
        <div class="layer" data-depth="0.5"></div>
        <div class="layer" data-depth="1"></div>
    </div>
    <script src="../js/parallax.js"></script>
    <main id="main-content">
        <div>
            <a href="evento.php" class="boton-descarga">Regresar</a>
        </div>
        <div class="detalles">
            <h2>Detalles del Evento</h2>

            <?php if ($evento): ?>
                <div class="ficha">

                    <h3><?php echo $evento['nombre_evento']; ?></h3>
                    <p><strong>Descripción:</strong> <?php echo $evento['descripcion']; ?></p>
                    <p><strong>Fecha:</strong> <?php echo $evento['fecha_evento']; ?></p>
                    <p><strong>Horario de Inicio:</strong> <?php echo $evento['horario_evento']; ?></p>
                    <p><strong>Horario de Finalización:</strong> <?php echo $evento['horario_fin']; ?></p>
                    <p><strong>Duración:</strong> <?php echo $evento['duracion_evento']; ?> minutos</p>

                </div>
                <div class="ficha">

                    <h3>Auditorio</h3>
                    <p><strong>Nombre:</strong> <?php echo $evento['nombre_auditorio']; ?></p>
                    <p><strong>Capacidad:</strong> <?php echo $evento['capacidad']; ?></p>
                    <p><strong>Ubicación:</strong> <?php echo $evento['ubicacion']; ?></p>

                </div>
                <div class="ficha">
                    <h3>Asistentes</h3>
                    <p><strong>Asistentes Confirmados:</strong> <?php echo $asistentes_confirmados; ?></p>
                    <p><strong>Asientos Restantes:</strong> <?php echo $asientos_restantes; ?></p>

                    <?php if (!empty($asistentes)): ?>
                        <table class="tabla-asistentes">
                            <thead>
                                <tr>
                                    <th class="asistentes-th">Nombre</th>
                                    <th class="asistentes-th">Apellido Paterno</th>
                                    <th class="asistentes-th">Apellido Materno</th>
                                    <th class="asistentes-th">Número de Cuenta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($asistentes as $asistente): ?>
                                    <tr class="asistentes-tr">
                                        <td class="asistentes-td"><?php echo $asistente['nombres']; ?></td>
                                        <td class="asistentes-td"><?php echo $asistente['ap_paterno']; ?></td>
                                        <td class="asistentes-td"><?php echo $asistente['ap_materno']; ?></td>
                                        <td class="asistentes-td"><?php echo $asistente['numero_cuenta']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="mensaje">No hay asistentes registrados para este evento.</p>
                    <?php endif; ?>
                <?php else: ?>
                    <p>Evento no encontrado.</p>
                <?php endif; ?>
            </div>
        </div>
        <a class="boton-descarga" href="fpdf/DescargarReporte.php?id=<?= $evento['id_evento'] ?>" target="_blank"
            class="btn">
            <i class="fa-solid fa-file-pdf"></i> Descargar lista de asistentes
        </a>
    </main>
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