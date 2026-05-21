<?php
header('Content-Type: text/html; charset=UTF-8');

include("conexion.php");

$sql = "SELECT f.mensaje, f.fecha, u.nombre
        FROM foro f
        LEFT JOIN usuarios u ON f.usuario_id = u.id
        ORDER BY f.fecha DESC
        LIMIT 50";

$resultado = $conexion->query($sql);
$mensajes = [];

while ($fila = $resultado->fetch_assoc()) {
    $mensajes[] = $fila;
}

echo json_encode($mensajes);

?>