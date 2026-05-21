<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include('../backend/conexion.php');

$usuarios = $conexion->query(
    "SELECT u.id, u.nombre, u.correo, u.rol, u.fecha_registro,
            COUNT(c.id) AS total_citas
     FROM usuarios u
     LEFT JOIN citas c ON c.usuario_id = u.id
     GROUP BY u.id
     ORDER BY u.fecha_registro DESC"
);

$citas_q = $conexion->query(
    "SELECT c.*, f.nombre AS fono_nombre
     FROM citas c
     LEFT JOIN fonoaudiologas f ON f.id = c.fonoaudiologa_id
     ORDER BY c.fecha DESC, c.hora DESC"
);

$citas_por_usuario = [];
if ($citas_q) {
    while ($c = $citas_q->fetch_assoc()) {
        $citas_por_usuario[$c['usuario_id']][] = $c;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Usuarios - NEXOVOZ</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Poppins',sans-serif;background:linear-gradient(140deg,#071a4e 0%,#0d2f6e 45%,#0a3d1f 100%);min-height:100vh;color:white;}

.navbar{display:flex;align-items:center;justify-content:space-between;padding:16px 40px;background:rgba(0,0,0,0.2);backdrop-filter:blur(8px);position:sticky;top:0;z-index:20;}
.nav-logo{width:48px;height:48px;border-radius:50%;border:2.5px solid #7dd63b;overflow:hidden;background:white;display:flex;align-items:center;justify-content:center;text-decoration:none;flex-shrink:0;}
.nav-logo img{width:100%;height:100%;object-fit:cover;}
.nav-title{font-size:16px;font-weight:800;}
.btn-volver{background:rgba(255,255,255,0.15);color:white;border:1px solid rgba(255,255,255,0.3);border-radius:30px;padding:8px 18px;font-size:13px;font-weight:600;text-decoration:none;transition:background 0.2s;}
.btn-volver:hover{background:rgba(255,255,255,0.28);}

.wrap{max-width:900px;margin:0 auto;padding:32px 36px 60px;}

.pg-hero{margin-bottom:28px;}
.pg-hero h1{font-size:26px;font-weight:800;}
.pg-hero p{color:rgba(255,255,255,0.55);font-size:13px;margin-top:4px;}

.stats-row{display:flex;gap:14px;flex-wrap:wrap;margin-bottom:28px;}
.stat-pill{background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);border-radius:20px;padding:12px 22px;display:flex;align-items:center;gap:10px;backdrop-filter:blur(8px);}
.stat-num{font-size:20px;font-weight:800;line-height:1;}
.stat-lbl{font-size:11px;color:rgba(255,255,255,0.5);font-weight:600;margin-top:2px;}

.sec-title{font-size:13px;font-weight:700;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:1.2px;margin-bottom:14px;display:flex;align-items:center;gap:8px;}
.sec-title::after{content:'';flex:1;height:1px;background:rgba(255,255,255,0.1);}

.u-card{background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:20px;overflow:hidden;margin-bottom:14px;backdrop-filter:blur(6px);transition:border-color 0.2s;}
.u-card.expanded{border-color:rgba(125,214,59,0.4);}
.u-header{display:flex;align-items:center;gap:14px;padding:18px 22px;cursor:pointer;user-select:none;}
.u-header:hover .u-name{color:#7dd63b;}
.u-avatar{width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#0039a6,#7dd63b);display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:800;flex-shrink:0;}
.u-info{flex:1;min-width:0;}
.u-name{font-size:15px;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.u-email{font-size:12px;color:rgba(255,255,255,0.5);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.u-meta{display:flex;align-items:center;gap:8px;flex-shrink:0;}
.rol-badge{display:inline-block;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:700;}
.rol-usuario{background:rgba(125,214,59,0.2);color:#7dd63b;border:1px solid rgba(125,214,59,0.35);}
.rol-fonoaudiologa{background:rgba(76,183,255,0.2);color:#4cb7ff;border:1px solid rgba(76,183,255,0.35);}
.rol-admin{background:rgba(255,180,0,0.2);color:#ffb400;border:1px solid rgba(255,180,0,0.35);}
.citas-badge{background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);border-radius:30px;padding:4px 12px;font-size:12px;font-weight:700;display:flex;align-items:center;gap:5px;}
.citas-badge.has-citas{background:rgba(125,214,59,0.15);border-color:rgba(125,214,59,0.3);color:#7dd63b;}
.expand-arrow{font-size:14px;color:rgba(255,255,255,0.4);transition:transform 0.25s;flex-shrink:0;}
.u-card.expanded .expand-arrow{transform:rotate(180deg);}

.u-body{display:none;border-top:1px solid rgba(255,255,255,0.08);padding:18px 22px;}
.u-card.expanded .u-body{display:block;}

.reg-date{font-size:12px;color:rgba(255,255,255,0.4);margin-bottom:14px;}

.citas-title{font-size:12px;font-weight:700;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:0.8px;margin-bottom:10px;}
.cita-row{background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:14px 16px;margin-bottom:8px;display:grid;grid-template-columns:auto 1fr 1fr 1fr;gap:12px;align-items:center;}
.cita-row:last-child{margin-bottom:0;}
.cita-num{width:30px;height:30px;border-radius:50%;background:#0d2f6e;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;}
.cita-field .cf-label{font-size:10px;color:rgba(255,255,255,0.4);font-weight:600;text-transform:uppercase;margin-bottom:2px;}
.cita-field .cf-val{font-size:13px;font-weight:600;}
.cita-dif{display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:rgba(125,214,59,0.15);color:#7dd63b;border:1px solid rgba(125,214,59,0.3);}

.no-citas{text-align:center;padding:20px;color:rgba(255,255,255,0.35);font-size:13px;}

.empty-state{text-align:center;padding:60px 20px;}
.empty-state .e-icon{font-size:48px;margin-bottom:14px;}

@media(max-width:700px){
  .navbar{padding:14px 18px;}
  .wrap{padding:22px 18px 50px;}
  .nav-title{display:none;}
  .cita-row{grid-template-columns:auto 1fr;gap:8px;}
  .cita-row .cita-field:nth-child(n+4){display:none;}
}
</style>
</head>
<body>

<nav class="navbar">
  <a href="/Nexovoz/pages/indexadmid.php" class="nav-logo">
    <img src="../assets/img/logo.png" alt="NEXOVOZ" onerror="this.style.display='none'">
  </a>
  <div class="nav-title">Usuarios y Citas</div>
  <a href="/Nexovoz/pages/indexadmid.php" class="btn-volver">&#8592; Panel admin</a>
</nav>

<div class="wrap">
  <div class="pg-hero">
    <h1>&#128101; Usuarios y citas</h1>
    <p>Listado de usuarios registrados con sus citas agendadas</p>
  </div>

  <?php
  $total_usuarios = $usuarios ? $usuarios->num_rows : 0;
  $total_citas_global = array_sum(array_map('count', $citas_por_usuario));
  ?>
  <div class="stats-row">
    <div class="stat-pill">
      <span style="font-size:22px;">&#128101;</span>
      <div><div class="stat-num"><?= $total_usuarios ?></div><div class="stat-lbl">Usuarios registrados</div></div>
    </div>
    <div class="stat-pill">
      <span style="font-size:22px;">&#128197;</span>
      <div><div class="stat-num"><?= $total_citas_global ?></div><div class="stat-lbl">Citas registradas</div></div>
    </div>
  </div>

  <div class="sec-title">Listado de usuarios</div>

  <?php if ($usuarios && $usuarios->num_rows > 0): ?>
  <?php $idx = 0; while ($u = $usuarios->fetch_assoc()): $idx++;
    $uid = $u['id'];
    $rolClass = match($u['rol']) {
      'fonoaudiologa' => 'rol-fonoaudiologa',
      'admin'         => 'rol-admin',
      default         => 'rol-usuario',
    };
    $inicial = mb_strtoupper(mb_substr($u['nombre'], 0, 1, 'UTF-8'));
    $citas = $citas_por_usuario[$uid] ?? [];
    $numCitas = count($citas);
  ?>
  <div class="u-card" id="card-<?= $uid ?>">
    <div class="u-header" onclick="toggleCard(<?= $uid ?>)">
      <div class="u-avatar"><?= htmlspecialchars($inicial) ?></div>
      <div class="u-info">
        <div class="u-name"><?= htmlspecialchars($u['nombre']) ?></div>
        <div class="u-email"><?= htmlspecialchars($u['correo']) ?></div>
      </div>
      <div class="u-meta">
        <span class="rol-badge <?= $rolClass ?>"><?= htmlspecialchars($u['rol']) ?></span>
        <span class="citas-badge <?= $numCitas > 0 ? 'has-citas' : '' ?>">
          &#128197; <?= $numCitas ?> cita<?= $numCitas !== 1 ? 's' : '' ?>
        </span>
        <span class="expand-arrow">&#9660;</span>
      </div>
    </div>
    <div class="u-body">
      <div class="reg-date">Registrado el <?= $u['fecha_registro'] !== '0000-00-00 00:00:00' ? date('d/m/Y', strtotime($u['fecha_registro'])) : '—' ?></div>

      <div class="citas-title">Citas agendadas</div>
      <?php if ($numCitas > 0): ?>
        <?php foreach ($citas as $ci => $c): ?>
        <div class="cita-row">
          <div class="cita-num"><?= $ci + 1 ?></div>
          <div class="cita-field">
            <div class="cf-label">Fecha</div>
            <div class="cf-val"><?= $c['fecha'] ? date('d/m/Y', strtotime($c['fecha'])) : '—' ?></div>
          </div>
          <div class="cita-field">
            <div class="cf-label">Hora</div>
            <div class="cf-val"><?= $c['hora'] ? substr($c['hora'], 0, 5) : '—' ?></div>
          </div>
          <div class="cita-field">
            <div class="cf-label">Paciente</div>
            <div class="cf-val"><?= htmlspecialchars($c['nombre_paciente'] ?? '—') ?></div>
          </div>
          <?php if ($c['tipo_dificultad']): ?>
          <div class="cita-field" style="grid-column:2/-1;">
            <div class="cf-label">Dificultad</div>
            <div class="cf-val"><span class="cita-dif"><?= htmlspecialchars($c['tipo_dificultad']) ?></span></div>
          </div>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="no-citas">&#128197; Este usuario no tiene citas agendadas</div>
      <?php endif; ?>
    </div>
  </div>
  <?php endwhile; ?>
  <?php else: ?>
  <div class="empty-state">
    <div class="e-icon">&#128101;</div>
    <p style="color:rgba(255,255,255,0.5);">No hay usuarios registrados aun.</p>
  </div>
  <?php endif; ?>
</div>

<script>
function toggleCard(id) {
  const card = document.getElementById('card-' + id);
  card.classList.toggle('expanded');
}
</script>
</body>
</html>
