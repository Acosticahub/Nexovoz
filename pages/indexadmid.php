<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
$conexion = mysqli_connect("localhost","root","","nexovoz");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>NEXOVOZ</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    background:linear-gradient(135deg,#0039a6,#0052cc);
    min-height:100vh;
    overflow-x:hidden;
    color:white;
}

/* NAVBAR */

.navbar{
    width:100%;
    padding:20px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.logo{
    width:75px;
    height:75px;
    border-radius:50%;
    overflow:hidden;
    background:white;
}

.logo img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.menu{
    display:flex;
    gap:30px;
}

.menu a{
    text-decoration:none;
    color:white;
    font-weight:500;
    transition:.3s;
}

.menu a:hover{
    color:#b6ff00;
}

.perfil{
    width:45px;
    height:45px;
    border-radius:50%;
    background:#dff6ff;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-shrink:0;
    transition:transform 0.2s;
}
.perfil:hover{transform:scale(1.1);}
.perfil svg{width:26px;height:26px;}

.user-dd{position:fixed;top:78px;right:40px;background:white;border-radius:16px;box-shadow:0 8px 30px rgba(0,0,0,0.25);padding:16px;min-width:200px;display:none;z-index:50;color:#0d2060;}
.user-dd.open{display:block;}
.user-dd .uname{font-weight:700;font-size:15px;margin-bottom:12px;padding-bottom:10px;border-bottom:1px solid #eee;}
.user-dd a{display:block;padding:8px 12px;border-radius:8px;text-decoration:none;color:#0d2060;font-size:13px;font-weight:600;transition:background 0.15s;}
.user-dd a:hover{background:#f0f4ff;}
.user-dd .logout-link{color:#c0392b;}

.edit-ov{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:200;justify-content:center;align-items:center;padding:20px;}
.edit-ov.open{display:flex;}
.edit-box{background:white;border-radius:20px;width:100%;max-width:420px;padding:28px;color:#0d2060;}
.edit-box h3{font-size:18px;font-weight:700;margin-bottom:18px;}
.efield{margin-bottom:14px;}
.efield label{display:block;font-size:13px;font-weight:600;margin-bottom:5px;}
.efield input{width:100%;padding:10px 14px;border:1.5px solid #dde3f0;border-radius:10px;font-size:14px;font-family:'Poppins',sans-serif;outline:none;background:#f8faff;}
.efield input:focus{border-color:#0039a6;background:white;}
.eactions{display:flex;gap:10px;margin-top:18px;}
.btn-esave{flex:1;background:#0039a6;color:white;border:none;border-radius:10px;padding:11px;font-weight:700;font-size:14px;cursor:pointer;font-family:'Poppins',sans-serif;}
.btn-ecancel{background:#f0f0f0;color:#555;border:none;border-radius:10px;padding:11px 20px;font-weight:600;font-size:14px;cursor:pointer;font-family:'Poppins',sans-serif;}

/* TITULO */

.titulo{
    width:100%;
    display:flex;
    justify-content:center;
    margin-top:20px;
}

.titulo-box{
    background:#4cb7ff;
    padding:15px 80px;
    border-radius:20px;
    box-shadow:0 10px 20px rgba(0,0,0,.2);
}

.titulo-box h1{
    font-size:55px;
    font-weight:700;
    color:black;
    letter-spacing:3px;
}

/* CARDS */

.cards{
    margin-top:100px;
    display:flex;
    justify-content:center;
    gap:70px;
    flex-wrap:wrap;
}

.card{
    width:330px;
    min-height:230px;
    background:#b6ff00;
    border-radius:30px;
    padding:30px;
    position:relative;
    box-shadow:0 15px 25px rgba(0,0,0,.3);
    transition:.4s;
}

.card:hover{
    transform:translateY(-10px) scale(1.03);
}

.card::after{
    content:"";
    position:absolute;
    bottom:-28px;
    left:50px;
    border-width:28px 28px 0 0;
    border-style:solid;
    border-color:#b6ff00 transparent transparent transparent;
}

.card i{
    font-size:75px;
    color:black;
    margin-bottom:20px;
}

.card h2{
    color:white;
    font-size:32px;
    margin-bottom:15px;
}

.card p{
    color:#222;
    font-size:15px;
    line-height:1.5;
    margin-bottom:25px;
}

.card button{
    padding:12px 30px;
    border:none;
    border-radius:15px;
    background:#0039a6;
    color:white;
    cursor:pointer;
    font-size:15px;
    font-weight:600;
    transition:.3s;
}

.card button:hover{
    background:#001c57;
}

/* FOOTER */

.footer{
    width:100%;
    text-align:center;
    margin-top:120px;
    padding-bottom:30px;
    color:#d7e9ff;
    font-size:14px;
}

/* RESPONSIVE */

@media(max-width:900px){

    .titulo-box h1{
        font-size:40px;
    }

    .cards{
        gap:40px;
    }

}

@media(max-width:600px){

    .navbar{
        flex-direction:column;
        gap:20px;
    }

    .menu{
        flex-wrap:wrap;
        justify-content:center;
    }

    .titulo-box{
        padding:15px 40px;
    }

    .titulo-box h1{
        font-size:32px;
    }

    .card{
        width:90%;
    }

}

</style>
</head>
<body>

<!-- NAVBAR -->

<header class="navbar">

    <div class="logo">
        <a href="/Nexovoz/pages/indexadmid.php" style="display:block;width:100%;height:100%;">
            <img src="../assets/img/logo.png">
        </a>
    </div>

    <div class="menu">
        <a href="/Nexovoz/pages/indexadmid.php">Inicio</a>
        <a href="/Nexovoz/pages/bibliotecafono.html">Biblioteca</a>
        <a href="/Nexovoz/pages/ejerciosfono.html">Ejercicios</a>
        <a href="/Nexovoz/pages/agendar_cita_fonoaudiologia.html">Apoyo</a>
    </div>

    <div class="perfil" onclick="toggleDd()" title="Mi perfil">
        <svg viewBox="0 0 24 24" fill="none" stroke="#0039a6" stroke-width="2" stroke-linecap="round">
            <circle cx="12" cy="8" r="4"/>
            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
        </svg>
    </div>

</header>

<div class="user-dd" id="userDd">
    <div class="uname"><?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Admin'); ?></div>
    <a href="#" onclick="abrirEditPerfil();return false;">Editar perfil</a>
    <a href="/Nexovoz/backend/cerrar_sesion.php" class="logout-link">Cerrar sesion</a>
</div>

<div class="edit-ov" id="editOv">
    <div class="edit-box">
        <h3>Editar perfil</h3>
        <form id="frmEdit" action="/Nexovoz/backend/editar_perfil.php" method="POST">
            <input type="hidden" name="nombre" id="eh-n">
            <input type="hidden" name="correo" id="eh-c">
            <input type="hidden" name="contraseña" id="eh-p">
            <div class="efield"><label>Nombre</label><input type="text" id="ei-n"></div>
            <div class="efield"><label>Correo</label><input type="email" id="ei-c"></div>
            <div class="efield"><label>Nueva contraseña (opcional)</label><input type="password" id="ei-p" placeholder="........"></div>
            <div class="eactions">
                <button type="button" class="btn-ecancel" onclick="cerrarEditPerfil()">Cancelar</button>
                <button type="button" class="btn-esave" onclick="guardarPerfil()">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- TITULO -->

<section class="titulo">

    <div class="titulo-box">
        <h1>NEXOVOZ</h1>
    </div>

</section>

<!-- CARDS -->

<section class="cards">

    <!-- USUARIO -->

    <div class="card">

        <i class="fa-solid fa-comments"></i>

        <h2>Usuario</h2>

        <p>
            Accede a herramientas de comunicación,
            recursos interactivos y apoyo personalizado.
        </p>

        <button onclick="entrarUsuario()">
            Entrar
        </button>

    </div>

    <!-- FONO -->

    <div class="card">

        <i class="fa-solid fa-user-doctor"></i>

        <h2>Fonodiólogo</h2>

        <p>
            Gestiona terapias, seguimiento de pacientes
            y materiales de apoyo profesional.
        </p>

        <button onclick="entrarFono()">
            Entrar
        </button>

    </div>

</section>

<!-- FOOTER -->

<div class="footer">
    © 2026 NEXOVOZ • Plataforma de apoyo comunicativo
</div>

<script>

function entrarUsuario(){
    window.location.href='/Nexovoz/pages/ver_usuarios.php';
}

function entrarFono(){
    window.location.href='/Nexovoz/pages/ejerciosfono.html';
}

function toggleDd(){
    document.getElementById('userDd').classList.toggle('open');
}

document.addEventListener('click',function(e){
    const dd=document.getElementById('userDd');
    const btn=document.querySelector('.perfil');
    if(dd&&btn&&!btn.contains(e.target)&&!dd.contains(e.target)) dd.classList.remove('open');
});

function abrirEditPerfil(){
    document.getElementById('editOv').classList.add('open');
    document.getElementById('userDd').classList.remove('open');
    fetch('/Nexovoz/backend/obtener_usuario.php').then(r=>r.json()).then(d=>{
        if(d){ document.getElementById('ei-n').value=d.nombre||''; document.getElementById('ei-c').value=d.correo||''; }
    }).catch(()=>{});
}

function cerrarEditPerfil(){
    document.getElementById('editOv').classList.remove('open');
}

function guardarPerfil(){
    const n=document.getElementById('ei-n').value.trim();
    const c=document.getElementById('ei-c').value.trim();
    const p=document.getElementById('ei-p').value;
    if(!n||!c){alert('Nombre y correo son obligatorios');return;}
    document.getElementById('eh-n').value=n;
    document.getElementById('eh-c').value=c;
    document.getElementById('eh-p').value=p;
    document.getElementById('frmEdit').submit();
}

</script>

</body>
</html>
