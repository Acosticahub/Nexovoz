<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');
include("conexion.php");

$result = $conexion->query(
    "SELECT id, titulo, descripcion, categoria, archivo, fecha
     FROM bibliotecafono
     ORDER BY fecha DESC
     LIMIT 100"
);

$items = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}

echo json_encode($items);
?>
