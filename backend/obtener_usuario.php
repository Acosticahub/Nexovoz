<?php

session_start();
include("conexion.php");

$id = $_SESSION['usuario_id'] ?? 0;

$stmt = $conexion->prepare("SELECT nombre, correo, rol FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

echo json_encode($usuario);

?>
