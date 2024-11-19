<!DOCTYPE html>
<html lang="es">
<head>
    <title>Inicio de Sesión</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/headerStyles.css">
    <link rel="stylesheet" href="../css/footerStyles.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <!-- Formulario de Inicio de Sesión -->
    <div class="parallax">
        <div class="layer" data-depth="0.2"></div>
        <div class="layer" data-depth="0.5"></div>
        <div class="layer" data-depth="1"></div>
    </div>
    <script src="../js/parallax.js"></script>
    <div class="login-wrapper">
     <a href="" onclick="window.history.back();" class="boton-regresar">Regresar</a>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>

        <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']); // Elimina el mensaje después de mostrarlo
        }
        ?>

        <form class="login-form" action="controlador/loginControlador.php" method="POST">
            <?php
                include "controlador/updateEvento.php";
            ?>
            <label for="numero_cuenta">Número de Cuenta:</label>
            <input type="text" name="numero_cuenta" required>
            
            <label for="nip">NIP:</label>
            <input type="password" name="nip" required>
            
            <button type="submit" name="btnLogin">Iniciar Sesión</button>
        </form>
    </div>
</div>

</body>
</html>
