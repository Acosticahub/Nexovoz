# Cómo ejecutar Nexovoz con WAMPP (WampServer)

---

## Paso 1 — Abrir WampServer

1. Busca **WampServer** en el menú inicio y ábrelo
2. Espera que el ícono de la barra de tareas (abajo a la derecha) se ponga en **verde** 🟢
   - Verde = todo funcionando ✅
   - Amarillo = algo no encendió bien
   - Rojo = hay un error

---

## Paso 2 — Copiar la carpeta del proyecto

1. Abre el Explorador de Archivos
2. Ve a la carpeta: `C:\wamp64\www\`
3. Copia toda la carpeta `Nexovoz` y pégala ahí

Debe quedar así:
```
C:\wamp64\www\Nexovoz\
```

Truco: también puedes hacer clic en el ícono verde 🟢 → **"www directory"** para abrir la carpeta directo.

---

## Paso 3 — Crear la base de datos

1. Haz clic en el ícono verde 🟢 → **phpMyAdmin**
   (o escribe en el navegador: `http://localhost/phpmyadmin`)
2. Usuario: `root`, Contraseña: (vacía, no escribas nada)
3. En el panel de la izquierda haz clic en **Nueva**
4. Escribe el nombre: `nexovoz` y haz clic en **Crear**
5. Selecciona la base de datos `nexovoz` en el panel izquierdo
6. Haz clic en la pestaña **Importar**
7. Haz clic en **Seleccionar archivo** y busca `nexovoz.sql` dentro de la carpeta `Nexovoz`
8. Haz clic en el botón **Importar** al final

Si aparece un mensaje verde, ¡funcionó! ✅

---

## Paso 4 — Abrir el proyecto

Escribe esto en el navegador:
```
http://localhost/Nexovoz/1Inisiodesesion.html
```

O haz clic en el ícono verde 🟢 → **My Projects** → **Nexovoz**.

---

## Si algo no funciona

**El ícono está en amarillo:**
- Haz clic derecho en el ícono → **Restart All Services**
- Espera que vuelva a verde

**Apache no enciende (puerto ocupado):**
- Clic en el ícono 🟢 → Apache → httpd.conf
- Cambia `Listen 80` a `Listen 8080`, guarda y reinicia
- Ahora abre: `http://localhost:8080/Nexovoz/1Inisiodesesion.html`

**Dice "Conexion Fallida":**
- Verifica que WampServer esté en verde
- Verifica que la base de datos `nexovoz` exista en phpMyAdmin

**Correo y contraseña no funcionan:**
- Verifica que importaste el archivo `nexovoz.sql`
- Prueba con: correo `acostamorenodaniela6@gmail.com` y contraseña `12345`

---

## Diferencia con XAMPP

| | XAMPP | WAMPP |
|---|---|---|
| Carpeta del proyecto | `C:\xampp\htdocs\` | `C:\wamp64\www\` |
| phpMyAdmin | `http://localhost/phpmyadmin` | `http://localhost/phpmyadmin` |
| Contraseña root | vacía | vacía |
| Archivo conexion.php | igual | igual |
