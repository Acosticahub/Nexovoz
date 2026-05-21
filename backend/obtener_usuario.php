<?php

session_start();
header('Content-Type: application/json; charset=UTF-8');
include("conexion.php");

$id = $_SESSION['usuario_id'] ?? 0;

$stmt = $conexion->prepare("SELECT nombre, correo, rol, avatar FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

if (!$usuario) {
    echo json_encode(['error' => 'no_session']);
} else {
    echo json_encode($usuario);
}

?>
