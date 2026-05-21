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

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $pass = $_POST['contraseña'];
    $rol = $_POST['rol'];

    // Verificar si el usuario ya existe
    $check = $conn->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $check->bind_param("s", $correo);
    $check->execute();

    $resultado = $check->get_result();

    if ($resultado->num_rows > 0) {

        echo "<script>
            alert('El usuario ya existe');
            window.location='../pages/1 2registro.html';
        </script>";

    } else {

        // Insertar usuario
        $stmt = $conn->prepare("INSERT INTO usuarios(nombre, correo, contraseña, rol) VALUES(?,?,?,?)");
        $stmt->bind_param("ssss", $nombre, $correo, $pass, $rol);

        if ($stmt->execute()) {

            echo "<script>
                alert('Registro exitoso');
                window.location='../1Inisiodesesion.html';
            </script>";

        } else {

            echo "Error al registrar";
        }
    }
}
?>
