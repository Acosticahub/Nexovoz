<?php

session_start();
header('Content-Type: application/json; charset=UTF-8');
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'msg' => 'Metodo no permitido']);
    exit;
}

$id     = $_SESSION['usuario_id'] ?? 0;
$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$pass   = $_POST['contrasena'] ?? '';

if (!$id) {
    echo json_encode(['ok' => false, 'msg' => 'Sesion no valida']);
    exit;
}

if (empty($nombre) || empty($correo)) {
    echo json_encode(['ok' => false, 'msg' => 'Nombre y correo son obligatorios']);
    exit;
}

$avatar_url = null;

if (!empty($_FILES['avatar']['tmp_name'])) {
    $ext    = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
    $allow  = ['jpg','jpeg','png','gif','webp'];
    if (!in_array($ext, $allow)) {
        echo json_encode(['ok' => false, 'msg' => 'Formato de imagen no permitido']);
        exit;
    }
    $dir = dirname(__DIR__) . '/uploads/avatars/';
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    $filename = 'avatar_' . $id . '_' . time() . '.' . $ext;
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $dir . $filename)) {
        $avatar_url = '/Nexovoz/uploads/avatars/' . $filename;
    }
}

if ($avatar_url) {
    if (!empty($pass)) {
        $stmt = $conexion->prepare("UPDATE usuarios SET nombre=?, correo=?, contraseña=?, avatar=? WHERE id=?");
        $stmt->bind_param("ssssi", $nombre, $correo, $pass, $avatar_url, $id);
    } else {
        $stmt = $conexion->prepare("UPDATE usuarios SET nombre=?, correo=?, avatar=? WHERE id=?");
        $stmt->bind_param("sssi", $nombre, $correo, $avatar_url, $id);
    }
} else {
    if (!empty($pass)) {
        $stmt = $conexion->prepare("UPDATE usuarios SET nombre=?, correo=?, contraseña=? WHERE id=?");
        $stmt->bind_param("sssi", $nombre, $correo, $pass, $id);
    } else {
        $stmt = $conexion->prepare("UPDATE usuarios SET nombre=?, correo=? WHERE id=?");
        $stmt->bind_param("ssi", $nombre, $correo, $id);
    }
}

if ($stmt->execute()) {
    $_SESSION['usuario_nombre'] = $nombre;
    $res = ['ok' => true, 'msg' => 'Cambios guardados', 'nombre' => $nombre];
    if ($avatar_url) $res['avatar'] = $avatar_url;
    echo json_encode($res);
} else {
    echo json_encode(['ok' => false, 'msg' => 'Error al guardar: ' . $conexion->error]);
}
?>
