# Proyecto Nexovoz

Plataforma web para ejercicios de lenguaje y fonoaudiología.

---

## Archivos del proyecto

```
Nexovoz/
│
├── pages/
│   ├── 1Inisiodesesion.html               → Login
│   ├── 1 2registro.html                   → Registro
│   ├── nexovozinicio.html                 → Dashboard usuario (glassmorphism)
│   ├── indexadmid.php                     → Panel Admin (glassmorphism, vistas por rol + gestión)
│   ├── ejerciosfono.html                  → Dashboard Fonoaudiólogo
│   ├── ver_usuarios.php                   → Admin: listado usuarios + accordion citas
│   ├── 3pruebadevoz.html                  → Prueba de voz (fases + progreso visual)
│   ├── progreso.html                      → Mi Progreso del usuario
│   ├── foro.html                          → Foro de usuarios
│   ├── biblioteca_lenguaje.html           → Biblioteca del usuario (glassmorphism)
│   ├── ejercicios_lenguaje.html           → Ejercicios del usuario (glassmorphism, videos fix)
│   ├── bibliotecafono.html                → Biblioteca del fonoaudiólogo
│   ├── agendar_cita_fonoaudiologia.html   → Agendar citas (guarda en BD)
│
├── backend/
│   ├── conexion.php            → Conexión a BD
│   ├── login.php               → Autenticación + set $_SESSION
│   ├── registro.php            → Registro de usuarios
│   ├── cerrar_sesion.php       → Cierre de sesión
│   ├── obtener_usuario.php     → GET: datos del usuario (nombre, correo, rol, avatar)
│   ├── editar_perfil.php       → POST JSON: actualiza nombre/correo/pass + sube avatar
│   ├── guardar_cita.php        → POST JSON: guarda cita en tabla citas
│   ├── obtener_ejercicios.php  → GET: ejercicios (tabla ejerciciosfono)
│   ├── guardar_resultado.php   → POST: guarda resultado prueba de voz
│   ├── obtener_progreso.php    → GET: última prueba + total pruebas del usuario
│   ├── biblioteca.php          → POST JSON: sube recurso a bibliotecafono (archivo + INSERT)
│   ├── mostrar_biblioteca.php  → GET JSON: lista recursos de bibliotecafono
│   ├── foro.php                → POST: nuevo mensaje en el foro
│   └── mostrar_foro.php        → GET: últimos 50 mensajes del foro
│
├── uploads/
│   ├── avatars/                → Imágenes de perfil subidas por usuarios
│   └── biblioteca/             → Archivos de recursos terapéuticos subidos por fonoaudiólogos
│
├── assets/
│   ├── img/logo.png            → Logo circular NEXOVOZ
│   ├── img/microfono.png       → Ícono micrófono
│   ├── css/styles.css          → (legacy, reemplazado por estilos inline)
│   └── js/script.js            → (legacy, lógica inline en 3pruebadevoz.html)
│
├── nexovoz.sql                 → Esquema BD (incluye columna avatar en usuarios)
│
└── docs/
    ├── README.md               → Este archivo
    ├── guia-xampp.md           → Cómo ejecutar con XAMPP
    └── guia-wampp.md           → Cómo ejecutar con WAMPP
```

---

## Tablas de la base de datos

| Tabla | Descripción |
|---|---|
| `usuarios` | id, nombre, correo, contraseña, rol (usuario/fonoaudiologa/admin), **avatar**, fecha_registro |
| `citas` | id, usuario_id, fonoaudiologa_id, fecha, hora, nombre_paciente, tipo_dificultad |
| `pruebas_voz` | id, usuario_id, pronunciacion, fluidez, articulacion, velocidad, diagnostico, recomendaciones, fecha |
| `ejercicios` | id, titulo, descripcion, categoria, video |
| `ejerciciosfono` | id, titulo, categoria, descripcion, archivo, video, fecha |
| `biblioteca` / `bibliotecafono` | id, titulo, descripcion, archivo, tipo_archivo, fecha |
| `foro` | id, usuario_id, mensaje, fecha |
| `fonoaudiologas` | id, nombre, especialidad |

> **Migración requerida** si la BD ya existe: `ALTER TABLE usuarios ADD COLUMN avatar VARCHAR(255) DEFAULT NULL;`

---

## ¿Cómo abrir el proyecto?

Lee la guía según el programa que uses:
- **XAMPP** → [guia-xampp.md](./guia-xampp.md)
- **WAMPP** → [guia-wampp.md](./guia-wampp.md)

---

## ¿Por dónde empieza el proyecto?

Abre en el navegador:
```
http://localhost/Nexovoz/1Inisiodesesion.html
```
