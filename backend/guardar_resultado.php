<?php

session_start();
header('Content-Type: text/html; charset=UTF-8');
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usuario_id      = $_SESSION['usuario_id'] ?? 0;
    $pronunciacion   = $_POST['pronunciacion'];
    $fluidez         = $_POST['fluidez'];
    $articulacion    = $_POST['articulacion'];
    $velocidad       = $_POST['velocidad'];
    $diagnostico     = $_POST['diagnostico'];
    $recomendaciones = $_POST['recomendaciones'];

    $stmt = $conexion->prepare(
        "INSERT INTO pruebas_voz (usuario_id, pronunciacion, fluidez, articulacion, velocidad, diagnostico, recomendaciones)
         VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("issssss", $usuario_id, $pronunciacion, $fluidez, $articulacion, $velocidad, $diagnostico, $recomendaciones);

    if ($stmt->execute()) {
        echo "ok";
    } else {
        echo "error";
    }
}

?>