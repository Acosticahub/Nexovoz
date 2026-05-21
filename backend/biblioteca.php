<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'msg' => 'Metodo no permitido']);
    exit;
}

$titulo      = trim($_POST['titulo']      ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$categoria   = trim($_POST['categoria']   ?? '');

if (empty($titulo)) {
    echo json_encode(['ok' => false, 'msg' => 'El titulo es obligatorio']);
    exit;
}

$archivo = '';

if (!empty($_FILES['archivo']['tmp_name'])) {
    $ext   = strtolower(pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION));
    $allow = ['pdf', 'doc', 'docx', 'pptx', 'png', 'jpg', 'jpeg', 'mp3', 'wav', 'mp4'];
    if (!in_array($ext, $allow)) {
        echo json_encode(['ok' => false, 'msg' => 'Formato de archivo no permitido']);
        exit;
    }
    if ($_FILES['archivo']['size'] > 20 * 1024 * 1024) {
        echo json_encode(['ok' => false, 'msg' => 'El archivo supera el limite de 20 MB']);
        exit;
    }
    $dir = dirname(__DIR__) . '/uploads/biblioteca/';
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $_FILES['archivo']['name']);
    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $dir . $filename)) {
        $archivo = '/Nexovoz/uploads/biblioteca/' . $filename;
    } else {
        echo json_encode(['ok' => false, 'msg' => 'Error al guardar el archivo en el servidor']);
        exit;
    }
}

$stmt = $conexion->prepare(
    "INSERT INTO bibliotecafono (titulo, descripcion, categoria, archivo) VALUES (?, ?, ?, ?)"
);
$stmt->bind_param("ssss", $titulo, $descripcion, $categoria, $archivo);

if ($stmt->execute()) {
    echo json_encode([
        'ok'          => true,
        'msg'         => 'Recurso guardado',
        'id'          => $conexion->insert_id,
        'titulo'      => $titulo,
        'descripcion' => $descripcion,
        'categoria'   => $categoria,
        'archivo'     => $archivo
    ]);
} else {
    echo json_encode(['ok' => false, 'msg' => 'Error al guardar: ' . $conexion->error]);
}
?>
