<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');
include("conexion.php");

$usuario_id = $_SESSION['usuario_id'] ?? 0;

$result = [
    'ultima_prueba'  => null,
    'total_pruebas'  => 0
];

$stmt = $conexion->prepare(
    "SELECT pronunciacion, fluidez, articulacion, velocidad, diagnostico, recomendaciones, fecha
     FROM pruebas_voz
     WHERE usuario_id = ?
     ORDER BY fecha DESC
     LIMIT 1"
);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
if ($row) {
    $result['ultima_prueba'] = $row;
}

$stmt2 = $conexion->prepare("SELECT COUNT(*) AS total FROM pruebas_voz WHERE usuario_id = ?");
$stmt2->bind_param("i", $usuario_id);
$stmt2->execute();
$cnt = $stmt2->get_result()->fetch_assoc();
$result['total_pruebas'] = $cnt['total'] ?? 0;

echo json_encode($result);
?>
