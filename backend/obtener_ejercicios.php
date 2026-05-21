<?php
header('Content-Type: application/json; charset=UTF-8');
include("conexion.php");

$result = $conexion->query("SELECT id, titulo, categoria, descripcion, video FROM ejercicios ORDER BY id DESC");
$ejercicios = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $ejercicios[] = $row;
    }
}
echo json_encode($ejercicios);
?>
