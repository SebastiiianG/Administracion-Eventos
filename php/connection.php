<?php
function connection(): mysqli {
    date_default_timezone_set("America/Mexico_City");

    $host = "127.0.0.1";
    $user = "root";
    $pass = "Edwin321";
    $bd = "eventos";

    // Establecer la conexión
    $connect = mysqli_connect($host, $user, $pass, $bd);

    // Verificar la conexión
    if (!$connect) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Retornar la conexión
    return $connect;
}
?>
