<?php
function connection(): bool|mysqli{
    date_default_timezone_set("America/Mexico_City");
$host = "127.0.0.1";
$user = "root";
$pass = "Edwin321";
$bd = "eventos";
$connect = mysqli_connect($host, $user, $pass);
if (!$connect) {
    die("Error de conexión: " . mysqli_connect_error());
}
if (!mysqli_select_db($connect, $bd)) {
    die("No se pudo seleccionar la base de datos: " . mysqli_error($connect));
}
return $connect;
}
?>