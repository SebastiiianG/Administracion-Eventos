<?php
session_start();
include "../connection.php"; 
$con = connection();

// Verificar si se ha enviado el formulario de inicio de sesión
if (isset($_POST['btnLogin'])) {
    // Recoger datos del formulario
    $numero_cuenta = $_POST['numero_cuenta'];
    $nip = $_POST['nip'];

    // Consulta para verificar el número de cuenta y NIP
    $sql = "SELECT * FROM usuario WHERE numero_cuenta = ?  AND nip = ?";
    $stmt = $con->prepare($sql); // Preparar consulta para evitar inyecciones SQL
    $stmt->bind_param("ss", $numero_cuenta, $nip); // Enlazar parámetros
    $stmt->execute(); // Ejecutar la consulta
    $resultado = $stmt->get_result(); // Obtener el resultado de la consulta
    $usuario = $resultado->fetch_assoc(); // Obtener el registro si existe

    if ($usuario) {
        // Autenticación exitosa
        $_SESSION['numero_cuenta'] = $usuario['numero_cuenta'];
        $_SESSION['nombres'] = $usuario['nombres'];
        $_SESSION['administrador'] = $usuario['administrador'];
        
        // Redirigir a la página principal
        header("Location: ../index.php");
        exit();
    } else {
        // Si la autenticación falla, almacenar el mensaje de error en una variable de sesión
        $_SESSION['error'] = "Número de cuenta o NIP incorrecto.";
        header("Location: ../login.php"); // Redirigir de vuelta al formulario
        exit();
    }
    $stmt->close();
}
?>
