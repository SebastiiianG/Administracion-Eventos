<?php
session_start();
include "../connection.php"; 
$con = connection();

// Verificar si se ha enviado el formulario de inicio de sesión
if (isset($_POST['btnLogin'])) {
    $numero_cuenta = $_POST['numero_cuenta'];
    $nip = $_POST['nip'];

    // Consulta para verificar el número de cuenta y NIP
    $sql = "SELECT * FROM usuario WHERE numero_cuenta = ?  AND nip = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $numero_cuenta, $nip);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    if ($usuario) {
        // Almacenar datos en la sesión
        $_SESSION['numero_cuenta'] = $usuario['numero_cuenta'];
        $_SESSION['nombres'] = $usuario['nombres'];
        $_SESSION['ap_paterno'] = $usuario['ap_paterno'];  
        $_SESSION['ap_materno'] = $usuario['ap_materno'];  
        $_SESSION['administrador'] = $usuario['administrador'];
        
        // Redirigir a la página principal
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['error'] = "Número de cuenta o NIP incorrecto.";
        header("Location: ../login.php");
        exit();
    }
    $stmt->close();
}
?>
