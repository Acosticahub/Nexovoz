<?php

session_start();
header('Content-Type: text/html; charset=UTF-8');
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo      = $_POST['titulo'];
    $categoria   = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];
    $video       = $_POST['video'];

    $stmt = $conexion->prepare("INSERT INTO ejercicios (titulo, categoria, descripcion, video) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $titulo, $categoria, $descripcion, $video);

    if ($stmt->execute()) {
        echo "<script>
            alert('Ejercicio guardado correctamente');
            window.location='../pages/ejerciosfono.html';
        </script>";
    } else {
        echo "<script>
            alert('Error al guardar el ejercicio');
            window.location='../pages/ejerciosfono.html';
        </script>";
    }
}

?>
