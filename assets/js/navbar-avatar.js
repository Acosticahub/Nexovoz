/**
 * navbar-avatar.js
 * Carga el avatar del usuario en #avatarBtn de cualquier página.
 * Expone window.updateGlobalAvatar(url) para actualización post-save.
 */
(function () {

  /* ── Inyectar CSS del botón avatar global ── */
  var s = document.createElement('style');
  s.textContent =
    '.nav-avatar-global{width:40px;height:40px;border-radius:50%;overflow:hidden;' +
    'cursor:pointer;background:rgba(255,255,255,0.15);border:2px solid rgba(255,255,255,0.3);' +
    'display:flex;align-items:center;justify-content:center;flex-shrink:0;padding:0;' +
    'transition:border-color 0.2s,transform 0.2s;}' +
    '.nav-avatar-global:hover{border-color:#7dd63b;transform:scale(1.05);}' +
    '.nav-avatar-global img{width:100%;height:100%;object-fit:cover;border-radius:50%;}';
  document.head.appendChild(s);

  /* ── Actualiza #avatarBtn con una URL ── */
  function setAvatar(url) {
    var btn = document.getElementById('avatarBtn');
    if (!btn || !url) return;
    btn.innerHTML = '<img src="' + url + '" alt="Avatar">';
  }

  /* ── Carga el avatar desde el backend ── */
  function loadAvatar() {
    var btn = document.getElementById('avatarBtn');
    if (!btn) return;
    fetch('/Nexovoz/backend/obtener_usuario.php')
      .then(function (r) { return r.json(); })
      .then(function (d) {
        if (!d || d.error) return;
        if (d.avatar) setAvatar(d.avatar);
        /* Sólo para botones simples (sin dropdown propio): asigna href al dashboard según rol */
        if (btn.dataset.nolink === undefined && btn.tagName === 'BUTTON') {
          var dest = d.rol === 'admin'
            ? '/Nexovoz/pages/indexadmid.php'
            : d.rol === 'fonoaudiologa'
              ? '/Nexovoz/pages/ejerciosfono.html'
              : '/Nexovoz/pages/nexovozinicio.html';
          btn.onclick = function () { window.location.href = dest; };
          btn.title = d.nombre ? 'Mi perfil — ' + d.nombre.split(' ')[0] : 'Mi perfil';
        }
      })
      .catch(function () {});
  }

  /* ── API pública ── */
  window.updateGlobalAvatar = function (url) {
    if (!url) return;
    setAvatar(url + (url.indexOf('?') === -1 ? '?t=' : '&t=') + Date.now());
  };

  /* ── Inicializar cuando el DOM esté listo ── */
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadAvatar);
  } else {
    loadAvatar();
  }

})();
