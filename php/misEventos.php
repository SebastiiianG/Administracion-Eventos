    <?php
    session_start(); 
    include "connection.php";
    include "controlador/controladorMisEventos.php";
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <title>Mis Eventos</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/headerStyles.css">
        <link rel="stylesheet" href="../css/footerStyles.css">
        <link rel="stylesheet" href="../css/misEventosStyles.css">
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
        <div class="parallax">
        <div class="layer" data-depth="0.2"></div>
        <div class="layer" data-depth="0.5"></div>
        <div class="layer" data-depth="1"></div>
    </div>
    <script src="../js/parallax.js"></script>      
        <div id="main-content">
            <div id="container-mis-eventos">
                        <h2>Mis eventos</h2>
            
                        <!-- Eventos Futuros -->
                        <section>
                            <h3>Próximos Eventos</h3>
                            <?php if (mysqli_num_rows($resultado_futuros) > 0): ?>
                                <?php while ($evento = mysqli_fetch_assoc($resultado_futuros)): ?>
                                    <div class="evento-item">
                                        <h3><?php echo $evento['nombre_evento']; ?></h3>
                                        <p><strong>Fecha:</strong> <?php echo $evento['fecha_evento']; ?></p>
                                        <p><strong>Horario:</strong> <?php echo $evento['horario_evento']; ?></p>
                                        <p><strong>Duración:</strong> <?php echo $evento['duracion_evento']; ?> minutos</p>
                                        <p><strong>Descripción:</strong> <?php echo $evento['descripcion']; ?></p>
                                        <p><strong>Auditorio::</strong> <?php echo $evento['nombre_auditorio']; ?></p>
            
                                        <!-- Bloque de consulta para verificar si ya está confirmado -->
                                        <?php
                                        $id_evento = $evento['id_evento'];
                                        $query_check = "SELECT * FROM asistencia WHERE id_evento = '$id_evento' AND numero_cuenta = '$numero_cuenta'";
                                        $check_result = mysqli_query($con, $query_check);
                                        $asistido = mysqli_num_rows($check_result) > 0;
                                        ?>
            
                                        <!-- Botón de Confirmar/Desconfirmar asistencia -->
                                        <form method="POST" action="controlador/confirmarAsistencia.php" onsubmit="guardarPosicion()">
                                            <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento']; ?>">
                                            <input type="hidden" name="origen" value="misEventos"> <!-- Campo oculto para el origen -->
            
                                            <?php if ($asistido): ?>
                                                <button type="submit" name="accion" value="desconfirmar" class="boton-accion">Desconfirmar asistencia</button>
                                            <?php else: ?>
                                                <button type="submit" name="accion" value="confirmar" class="boton-accion">Confirmar asistencia</button>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p>No tienes eventos futuros confirmados.</p>
                            <?php endif; ?>
                        </section>
            
            
                        <!-- Eventos Pasados -->
                        <section>
                            <h3>Eventos Finalizados</h3>
                            <?php if (mysqli_num_rows($resultado_pasados) > 0): ?>
                                <?php while ($evento = mysqli_fetch_assoc($resultado_pasados)): ?>
                                    <div class="evento-item">
                                        <h3><?php echo $evento['nombre_evento']; ?></h3>
                                        <p><strong>Fecha:</strong> <?php echo $evento['fecha_evento']; ?></p>
                                        <p><strong>Horario:</strong> <?php echo $evento['horario_evento']; ?></p>
                                        <p><strong>Duración:</strong> <?php echo $evento['duracion_evento']; ?> minutos</p>
                                        <p><strong>Descripción:</strong> <?php echo $evento['descripcion']; ?></p>
                                        <p><strong>Auditorio:</strong> <?php echo $evento['nombre_auditorio']; ?></p>
                                        <p><strong>Ubicación:</strong> <?php echo $evento['ubicacion']; ?></p>
                                        <p><strong>Status:</strong> Evento finalizado</p>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p>No tienes eventos pasados.</p>
                            <?php endif; ?>
                        </section>
                    </div>
            
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