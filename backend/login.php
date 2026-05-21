<?php

session_start();
header('Content-Type: text/html; charset=UTF-8');

$server = "localhost";
$username = "root";
$password = "";
$dbname = "nexovoz";

$conn = new mysqli($server, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexion Fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $correo = $_POST['correo'];
    $pass = $_POST['contraseña'];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $pass === $user['contraseña']) {

        $_SESSION['usuario_id']     = $user['id'];
        $_SESSION['usuario_nombre'] = $user['nombre'];
        $_SESSION['usuario_rol']    = $user['rol'];

        if ($user['rol'] === 'fonoaudiologa') {
            header("Location: ../pages/indexadmid.php");
        } else {
            header("Location: ../pages/nexovozinicio.html");
        }
        exit();

    } else {

        echo "<script>
            alert('Intentar Nuevamente Conectarte');
            window.location='../1Inisiodesesion.html';
        </script>";
    }
}
?>
