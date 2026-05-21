<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
$conexion = mysqli_connect("localhost","root","","nexovoz");
$adminNombre = htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Administrador');
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - NEXOVOZ</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Poppins',sans-serif;background:linear-gradient(140deg,#071a4e 0%,#0d2f6e 45%,#0a3d1f 100%);min-height:100vh;color:white;overflow-x:hidden;}

/* ── NAVBAR ── */
.navbar{display:flex;align-items:center;justify-content:space-between;padding:16px 40px;background:rgba(0,0,0,0.2);backdrop-filter:blur(8px);position:sticky;top:0;z-index:30;}
.nav-logo{width:52px;height:52px;border-radius:50%;border:2.5px solid #7dd63b;overflow:hidden;background:white;display:flex;align-items:center;justify-content:center;text-decoration:none;flex-shrink:0;}
.nav-logo img{width:100%;height:100%;object-fit:cover;}
.nav-logo-txt{font-size:9px;font-weight:800;color:#0d2060;text-align:center;line-height:1.2;display:none;}
.nav-center{font-size:17px;font-weight:800;letter-spacing:0.5px;}
.nav-badge{background:#7dd63b;color:#0d2060;font-size:11px;font-weight:700;border-radius:20px;padding:2px 10px;margin-left:8px;}
.avatar-btn{width:42px;height:42px;border-radius:50%;background:#dff6ff;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:none;overflow:hidden;transition:transform 0.2s;}
.avatar-btn:hover{transform:scale(1.08);}
.avatar-btn svg{width:24px;height:24px;}
.user-dd{position:fixed;top:76px;right:40px;background:white;border-radius:18px;box-shadow:0 10px 40px rgba(0,0,0,0.3);padding:18px;min-width:210px;display:none;z-index:100;color:#0d2060;}
.user-dd.open{display:block;}
.user-dd .uname{font-weight:700;font-size:14px;margin-bottom:12px;padding-bottom:10px;border-bottom:1px solid #eee;color:#0d2060;}
.user-dd a{display:block;padding:9px 12px;border-radius:10px;text-decoration:none;color:#0d2060;font-size:13px;font-weight:600;transition:background 0.15s;}
.user-dd a:hover{background:#f0f4ff;}
.user-dd .logout-a{color:#c0392b;}

/* ── HERO ── */
.hero{text-align:center;padding:44px 20px 10px;}
.hero-tag{display:inline-block;background:rgba(125,214,59,0.15);border:1px solid rgba(125,214,59,0.35);color:#7dd63b;font-size:12px;font-weight:700;border-radius:30px;padding:5px 18px;margin-bottom:16px;letter-spacing:1px;}
.hero h1{font-size:40px;font-weight:800;margin-bottom:8px;}
.hero p{color:rgba(255,255,255,0.55);font-size:14px;}

/* ── SECTION TITLE ── */
.sec-title{font-size:13px;font-weight:700;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:1.5px;margin:36px 40px 16px;display:flex;align-items:center;gap:10px;}
.sec-title::after{content:'';flex:1;height:1px;background:rgba(255,255,255,0.1);}

/* ── ROLE CARDS ── */
.role-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;padding:0 40px;max-width:900px;margin:0 auto;}
.role-card{background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.13);border-radius:28px;padding:30px 28px;display:flex;flex-direction:column;gap:14px;backdrop-filter:blur(8px);transition:all 0.25s;position:relative;overflow:hidden;cursor:pointer;}
.role-card::before{content:'';position:absolute;width:110px;height:110px;border-radius:50%;background:rgba(125,214,59,0.06);top:-30px;right:-30px;}
.role-card:hover{background:rgba(255,255,255,0.14);transform:translateY(-5px);box-shadow:0 18px 40px rgba(0,0,0,0.3);border-color:rgba(125,214,59,0.45);}
.role-icon{font-size:48px;line-height:1;margin-bottom:4px;}
.role-name{font-size:22px;font-weight:800;}
.role-desc{font-size:13px;color:rgba(255,255,255,0.6);line-height:1.6;flex:1;}
.role-btn{align-self:flex-start;background:#7dd63b;color:#0d2060;border:none;border-radius:20px;padding:10px 24px;font-size:13px;font-weight:700;cursor:pointer;font-family:'Poppins',sans-serif;transition:background 0.2s;}
.role-btn:hover{background:#8fe84e;}

/* ── MANAGEMENT CARDS ── */
.mgmt-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;padding:0 40px;max-width:900px;margin:0 auto 50px;}
.mgmt-card{background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:22px;padding:22px 20px;display:flex;align-items:center;gap:14px;text-decoration:none;color:white;transition:all 0.2s;backdrop-filter:blur(6px);}
.mgmt-card:hover{background:rgba(255,255,255,0.13);transform:translateY(-3px);border-color:rgba(125,214,59,0.35);}
.mgmt-card .m-icon{font-size:28px;flex-shrink:0;}
.mgmt-card .m-label{font-size:14px;font-weight:700;}
.mgmt-card .m-sub{font-size:11px;color:rgba(255,255,255,0.5);margin-top:2px;}

/* ── EDIT MODAL ── */
.edit-ov{display:none;position:fixed;inset:0;background:rgba(5,15,50,0.7);z-index:200;justify-content:center;align-items:center;padding:20px;backdrop-filter:blur(4px);}
.edit-ov.open{display:flex;}
.edit-box{background:white;border-radius:24px;width:100%;max-width:440px;padding:30px;color:#0d2060;position:relative;max-height:90vh;overflow-y:auto;}
.edit-box h3{font-size:18px;font-weight:800;margin-bottom:20px;}
.edit-close{position:absolute;top:16px;right:18px;background:#f0f0f0;border:none;border-radius:50%;width:30px;height:30px;font-size:15px;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#555;}
.edit-close:hover{background:#e0e0e0;}

.avatar-row{display:flex;align-items:center;gap:14px;margin-bottom:20px;padding:14px;background:#f5f8ff;border-radius:14px;}
.av-preview{width:58px;height:58px;border-radius:50%;background:#e0e8ff;overflow:hidden;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.av-preview img{width:100%;height:100%;object-fit:cover;}
.av-preview svg{width:30px;height:30px;}
.av-change-btn{background:#0d2f6e;color:white;border:none;border-radius:10px;padding:8px 16px;font-size:12px;font-weight:600;cursor:pointer;font-family:'Poppins',sans-serif;}
.av-hint{font-size:11px;color:#888;margin-top:3px;}

.efield{margin-bottom:14px;}
.efield label{display:block;font-size:12px;font-weight:700;color:#555;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.5px;}
.efield input{width:100%;padding:11px 14px;border:1.5px solid #dde3f0;border-radius:12px;font-size:14px;font-family:'Poppins',sans-serif;outline:none;background:#f8faff;color:#0d2060;}
.efield input:focus{border-color:#0039a6;background:white;}
.eactions{display:flex;gap:10px;margin-top:20px;}
.btn-esave{flex:1;background:#0d2f6e;color:white;border:none;border-radius:12px;padding:13px;font-weight:700;font-size:14px;cursor:pointer;font-family:'Poppins',sans-serif;transition:background 0.2s;}
.btn-esave:hover{background:#1a3bbf;}
.btn-esave:disabled{opacity:0.6;cursor:default;}
.btn-ecancel{background:#f0f0f0;color:#555;border:none;border-radius:12px;padding:13px 22px;font-weight:600;font-size:14px;cursor:pointer;font-family:'Poppins',sans-serif;}

/* TOAST */
#toast-admin{position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#0d2f6e;color:white;padding:12px 26px;border-radius:30px;font-size:13px;font-weight:600;box-shadow:0 8px 24px rgba(0,0,0,0.3);z-index:9999;opacity:0;transition:opacity 0.3s;pointer-events:none;}

/* FOOTER */
.footer{text-align:center;padding:16px 0 30px;color:rgba(255,255,255,0.3);font-size:13px;}

@media(max-width:760px){
  .navbar{padding:14px 18px;}
  .nav-center{display:none;}
  .role-grid,.mgmt-grid{grid-template-columns:1fr;padding:0 18px;}
  .sec-title{margin:28px 18px 14px;}
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <a href="/Nexovoz/pages/indexadmid.php" class="nav-logo" title="NEXOVOZ">
    <img src="../assets/img/logo.png" alt="NEXOVOZ" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
    <span class="nav-logo-txt">NEXO<br>VOZ</span>
  </a>
  <div class="nav-center">NEXOVOZ <span class="nav-badge">Admin</span></div>
  <button class="avatar-btn" id="avatarBtn" onclick="toggleDd()" title="Mi perfil" data-nolink>
    <svg viewBox="0 0 24 24" fill="none" stroke="#0039a6" stroke-width="2" stroke-linecap="round">
      <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
    </svg>
  </button>
</nav>

<!-- USER DROPDOWN -->
<div class="user-dd" id="userDd">
  <div class="uname"><?= $adminNombre ?></div>
  <a href="#" onclick="abrirEditPerfil();return false;">&#9998; Editar perfil</a>
  <a href="/Nexovoz/backend/cerrar_sesion.php" class="logout-a">&#x21E5; Cerrar sesion</a>
</div>

<!-- HERO -->
<section class="hero">
  <div class="hero-tag">PANEL DE ADMINISTRACION</div>
  <h1>Bienvenido, <?= $adminNombre ?></h1>
  <p>Selecciona un modulo para gestionar o navega a una vista de rol</p>
</section>

<!-- ROLE CARDS -->
<div class="sec-title">&#128100; Vistas por rol</div>
<div class="role-grid" style="padding:0 40px;max-width:860px;margin:0 auto;">

  <div class="role-card" onclick="window.location.href='/Nexovoz/pages/nexovozinicio.html'">
    <div class="role-icon">&#128172;</div>
    <div class="role-name">Usuario</div>
    <div class="role-desc">Accede a herramientas de comunicacion, recursos interactivos y apoyo personalizado.</div>
    <button class="role-btn">Entrar como usuario</button>
  </div>

  <div class="role-card" onclick="window.location.href='/Nexovoz/pages/ejerciosfono.html'">
    <div class="role-icon">&#129658;</div>
    <div class="role-name">Fonodiologo</div>
    <div class="role-desc">Gestiona terapias, seguimiento de pacientes y materiales de apoyo profesional.</div>
    <button class="role-btn">Entrar como fono</button>
  </div>

</div>

<!-- MANAGEMENT -->
<div class="sec-title" style="margin-top:36px;">&#128295; Gestion administrativa</div>
<div class="mgmt-grid">

  <a href="/Nexovoz/pages/ver_usuarios.php" class="mgmt-card">
    <span class="m-icon">&#128101;</span>
    <div><div class="m-label">Usuarios y citas</div><div class="m-sub">Ver usuarios registrados y sus citas</div></div>
  </a>

  <a href="/Nexovoz/pages/ejerciosfono.html" class="mgmt-card">
    <span class="m-icon">&#128218;</span>
    <div><div class="m-label">Ejercicios y biblioteca</div><div class="m-sub">Gestionar materiales terapeuticos</div></div>
  </a>

  <a href="/Nexovoz/pages/agendar_cita_fonoaudiologia.html" class="mgmt-card">
    <span class="m-icon">&#128197;</span>
    <div><div class="m-label">Agenda de citas</div><div class="m-sub">Ver y gestionar citas programadas</div></div>
  </a>

</div>

<!-- EDIT PROFILE MODAL -->
<div class="edit-ov" id="editOv" onclick="cerrarFuera(event)">
  <div class="edit-box">
    <button class="edit-close" onclick="cerrarEditPerfil()">&#x2715;</button>
    <h3>Editar perfil</h3>

    <div class="avatar-row">
      <div class="av-preview" id="avPreview">
        <svg viewBox="0 0 24 24" fill="none" stroke="#0039a6" stroke-width="1.8" stroke-linecap="round">
          <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
        </svg>
      </div>
      <div>
        <button class="av-change-btn" onclick="document.getElementById('av-file').click()">Cambiar foto</button>
        <input type="file" id="av-file" accept="image/*" style="display:none" onchange="previewAv(event)">
        <div class="av-hint">JPG, PNG o WEBP. Max 2 MB</div>
      </div>
    </div>

    <div class="efield"><label>Nombre</label><input type="text" id="ei-n" placeholder="Tu nombre completo"></div>
    <div class="efield"><label>Correo</label><input type="email" id="ei-c" placeholder="tucorreo@email.com"></div>
    <div class="efield"><label>Nueva contrasena (opcional)</label><input type="password" id="ei-p" placeholder="........"></div>

    <div class="eactions">
      <button class="btn-ecancel" onclick="cerrarEditPerfil()">Cancelar</button>
      <button class="btn-esave" id="btnSave" onclick="guardarPerfil()">Guardar cambios</button>
    </div>
  </div>
</div>

<div id="toast-admin"></div>
<div class="footer">© 2026 NEXOVOZ • Plataforma de apoyo comunicativo</div>

<script>
function toggleDd(){
  document.getElementById('userDd').classList.toggle('open');
}
document.addEventListener('click',function(e){
  const dd=document.getElementById('userDd');
  const btn=document.getElementById('avatarBtn');
  if(dd&&btn&&!btn.contains(e.target)&&!dd.contains(e.target)) dd.classList.remove('open');
});

function abrirEditPerfil(){
  document.getElementById('editOv').classList.add('open');
  document.getElementById('userDd').classList.remove('open');
  fetch('/Nexovoz/backend/obtener_usuario.php')
    .then(r=>r.json())
    .then(d=>{
      if(d && !d.error){
        document.getElementById('ei-n').value = d.nombre||'';
        document.getElementById('ei-c').value = d.correo||'';
        if(d.avatar){
          document.getElementById('avPreview').innerHTML =
            '<img src="'+d.avatar+'" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">';
        }
      }
    }).catch(()=>{});
}

function cerrarEditPerfil(){
  document.getElementById('editOv').classList.remove('open');
}
function cerrarFuera(e){
  if(e.target===document.getElementById('editOv')) cerrarEditPerfil();
}

function previewAv(e){
  const file=e.target.files[0]; if(!file) return;
  const reader=new FileReader();
  reader.onload=ev=>{
    document.getElementById('avPreview').innerHTML=
      '<img src="'+ev.target.result+'" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">';
  };
  reader.readAsDataURL(file);
}

function guardarPerfil(){
  const n=document.getElementById('ei-n').value.trim();
  const c=document.getElementById('ei-c').value.trim();
  const p=document.getElementById('ei-p').value;
  if(!n||!c){alert('Nombre y correo son obligatorios');return;}
  const btn=document.getElementById('btnSave');
  btn.disabled=true; btn.textContent='Guardando...';
  const fd=new FormData();
  fd.append('nombre',n); fd.append('correo',c);
  if(p) fd.append('contrasena',p);
  const av=document.getElementById('av-file');
  if(av.files[0]) fd.append('avatar',av.files[0]);
  fetch('/Nexovoz/backend/editar_perfil.php',{method:'POST',body:fd})
    .then(r=>r.json())
    .then(d=>{
      if(d.ok){
        if(d.avatar) window.updateGlobalAvatar && window.updateGlobalAvatar(d.avatar);
        cerrarEditPerfil();
        toast('Cambios guardados correctamente');
      } else { alert(d.msg||'Error al guardar'); }
    })
    .catch(()=>alert('Error de conexion'))
    .finally(()=>{btn.disabled=false;btn.textContent='Guardar cambios';});
}

function toast(msg){
  const t=document.getElementById('toast-admin');
  t.textContent=msg; t.style.opacity='1';
  setTimeout(()=>{t.style.opacity='0';},2800);
}
</script>
<script src="../assets/js/navbar-avatar.js"></script>
</body>
</html>
