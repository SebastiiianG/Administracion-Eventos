<?php
function connection(){
    date_default_timezone_set("America/Mexico_City");
    $host = "localhost";
    $user = "root";
    $pass = "";
    $bd = "eventos";
    $connect = mysqli_connect($host, $user, $pass);

    mysqli_select_db($connect, $bd);
    //$conexion=new mysqli("localhost", "root", "", "eventos"); //Usuario, contraseña y nombre de la bd
    //$conexion->set_charset("utf-8"); //Para que el proyecto reconozca caractéres especiales
    return $connect;
}

?>