<?php

session_start();
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id     = $_SESSION['usuario_id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $pass   = $_POST['contraseña'];

    if (!empty($pass)) {
        $stmt = $conexion->prepare("UPDATE usuarios SET nombre=?, correo=?, contraseña=? WHERE id=?");
        $stmt->bind_param("sssi", $nombre, $correo, $pass, $id);
    } else {
        $stmt = $conexion->prepare("UPDATE usuarios SET nombre=?, correo=? WHERE id=?");
        $stmt->bind_param("ssi", $nombre, $correo, $id);
    }

    if ($stmt->execute()) {
        $_SESSION['usuario_nombre'] = $nombre;
        echo "<script>
            alert('Cambios guardados correctamente');
            window.location='../pages/nexovozinicio.html';
        </script>";
    } else {
        echo "<script>
            alert('Error al guardar los cambios');
            window.location='../pages/nexovozinicio.html';
        </script>";
    }
}
?>
