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

    $stmt = $conn->prepare("SELECT * FROM sesion WHERE nombre = ?");
    $stmt->bind_param("s", $nombre);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $pass === $user['password']) {

        header("Location: men.pcsystem.html");
        exit();

    } else {

        echo "<script>
            alert('Intentar Nuevamente Conectarte');
            window.location='login.html';
        </script>";
    }
}
?>