<?php

$server = "localhost";
$username = "root";
$password = "";
$dbname = "nexovoz";

$conn = new mysqli($server, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexion Fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nombre = $_POST['user'];
    $pass = $_POST['pass'];

    // Verificar si el usuario ya existe
    $check = $conn->prepare("SELECT * FROM sesion WHERE nombre = ?");
    $check->bind_param("s", $nombre);
    $check->execute();

    $resultado = $check->get_result();

    if ($resultado->num_rows > 0) {

        echo "<script>
            alert('El usuario ya existe');
            window.location='registro.html';
        </script>";

    } else {

        // Insertar usuario
        $stmt = $conn->prepare("INSERT INTO sesion(nombre,password) VALUES(?,?)");
        $stmt->bind_param("ss", $nombre, $pass);

        if ($stmt->execute()) {

            echo "<script>
                alert('Registro exitoso');
                window.location='login.html';
            </script>";

        } else {

            echo "Error al registrar";
        }
    }
}
?>