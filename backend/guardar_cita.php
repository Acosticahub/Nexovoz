<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id      = $_SESSION['usuario_id'] ?? null;
    $fonoaudiologa_id = intval($_POST['fonoaudiologa_id'] ?? 0) ?: null;
    $fecha           = trim($_POST['fecha'] ?? '');
    $hora            = trim($_POST['hora']  ?? '');
    $nombre_paciente = trim($_POST['nombre_paciente'] ?? '');
    $tipo_dificultad = trim($_POST['tipo_dificultad']  ?? '');

    if (!$fecha || !$hora || !$nombre_paciente) {
        echo json_encode(['ok' => false, 'msg' => 'Campos requeridos incompletos']);
        exit;
    }

    $stmt = $conexion->prepare(
        "INSERT INTO citas (usuario_id, fonoaudiologa_id, fecha, hora, nombre_paciente, tipo_dificultad)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("iissss", $usuario_id, $fonoaudiologa_id, $fecha, $hora, $nombre_paciente, $tipo_dificultad);

    if ($stmt->execute()) {
        echo json_encode(['ok' => true, 'msg' => 'Cita agendada correctamente']);
    } else {
        echo json_encode(['ok' => false, 'msg' => 'Error al guardar: ' . $conexion->error]);
    }
} else {
    echo json_encode(['ok' => false, 'msg' => 'Metodo no permitido']);
}
?>
