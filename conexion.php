<?php

$server = "localhost";
$username = "root";
$password = "";
$dbname = "nexovoz";

$conexion = new mysqli($server, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Conexion Fallida: " . $conexion->connect_error);
}

?>
