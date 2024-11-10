<?php
session_start();
session_unset();
session_destroy();
header("Location: ../index.php"); // Redirecciona al usuario a la página principal
exit();
?>
