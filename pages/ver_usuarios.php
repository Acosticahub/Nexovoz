<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include('../backend/conexion.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Usuarios - NEXOVOZ</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
*{ margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }

body{
    background:linear-gradient(135deg,#0039a6,#0052cc);
    min-height:100vh;
    color:white;
    padding:30px 40px;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.header h1{
    font-size:28px;
    font-weight:700;
}

.btn-volver{
    background:#b6ff00;
    color:#0039a6;
    border:none;
    border-radius:15px;
    padding:10px 24px;
    font-size:14px;
    font-weight:700;
    cursor:pointer;
    text-decoration:none;
    font-family:'Poppins',sans-serif;
}

.btn-volver:hover{ background:#a0e600; }

table{
    width:100%;
    border-collapse:collapse;
    background:rgba(255,255,255,0.1);
    border-radius:20px;
    overflow:hidden;
}

thead{
    background:rgba(0,0,0,0.3);
}

thead th{
    padding:16px 20px;
    text-align:left;
    font-size:14px;
    font-weight:600;
    text-transform:uppercase;
    letter-spacing:0.05em;
}

tbody tr{
    border-bottom:1px solid rgba(255,255,255,0.1);
    transition:background 0.2s;
}

tbody tr:hover{
    background:rgba(255,255,255,0.1);
}

tbody td{
    padding:14px 20px;
    font-size:14px;
}

.rol-badge{
    display:inline-block;
    padding:4px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.rol-usuario{ background:#b6ff00; color:#0039a6; }
.rol-fonoaudiologa{ background:#4cb7ff; color:#0039a6; }

.empty{
    text-align:center;
    padding:40px;
    opacity:0.7;
    font-size:16px;
}
</style>
</head>
<body>

<div class="header">
    <h1>Usuarios registrados</h1>
    <a href="/Nexovoz/pages/indexadmid.php" class="btn-volver">← Volver al panel</a>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
        </tr>
    </thead>
    <tbody>
<?php
$result = $conexion->query("SELECT id, nombre, correo, rol FROM usuarios ORDER BY id ASC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rolClass = $row['rol'] === 'fonoaudiologa' ? 'rol-fonoaudiologa' : 'rol-usuario';
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['nombre']}</td>
            <td>{$row['correo']}</td>
            <td><span class='rol-badge {$rolClass}'>{$row['rol']}</span></td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='4' class='empty'>No hay usuarios registrados.</td></tr>";
}
?>
    </tbody>
</table>

</body>
</html>
