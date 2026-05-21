<?php

session_start();
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usuario_id = $_SESSION['usuario_id'] ?? 0;
    $mensaje    = $_POST['mensaje'];

    $stmt = $conexion->prepare("INSERT INTO foro (usuario_id, mensaje) VALUES (?, ?)");
    $stmt->bind_param("is", $usuario_id, $mensaje);

    if ($stmt->execute()) {
        echo "ok";
    } else {
        echo "error";
    }
}

?>