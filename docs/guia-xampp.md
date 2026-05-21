# Cómo ejecutar Nexovoz con XAMPP

---

## Paso 1 — Abrir XAMPP

1. Busca **XAMPP Control Panel** en tu computador y ábrelo
2. Haz clic en **Start** al lado de **Apache**
3. Haz clic en **Start** al lado de **MySQL**
4. Los dos deben quedar en verde ✅

---

## Paso 2 — Copiar la carpeta del proyecto

1. Abre el Explorador de Archivos
2. Ve a la carpeta: `C:\xampp\htdocs\`
3. Copia toda la carpeta `Nexovoz` y pégala ahí

Debe quedar así:
```
C:\xampp\htdocs\Nexovoz\
```

---

## Paso 3 — Crear la base de datos

1. Abre el navegador y escribe: `http://localhost/phpmyadmin`
2. En el panel de la izquierda haz clic en **Nueva** (o New)
3. Escribe el nombre: `nexovoz` y haz clic en **Crear**
4. Selecciona la base de datos `nexovoz` en el panel izquierdo
5. Haz clic en la pestaña **Importar**
6. Haz clic en **Seleccionar archivo** y busca el archivo `nexovoz.sql` que está dentro de la carpeta `Nexovoz`
7. Haz clic en el botón **Importar** al final de la página

Si aparece un mensaje verde, ¡funcionó! ✅

---

## Paso 4 — Abrir el proyecto

Escribe esto en el navegador:
```
http://localhost/Nexovoz/1Inisiodesesion.html
```

Deberías ver la pantalla de login de Nexovoz.

---

## Si algo no funciona

**Apache no enciende:**
- Otro programa está usando el mismo puerto
- Solución: En XAMPP haz clic en Config → Apache → httpd.conf, busca `Listen 80` y cámbialo a `Listen 8080`. Guarda y vuelve a encender.
- Ahora abre: `http://localhost:8080/Nexovoz/1Inisiodesesion.html`

**Dice "Conexion Fallida":**
- Verifica que MySQL esté encendido (verde)
- Verifica que la base de datos `nexovoz` exista en phpMyAdmin

**Correo y contraseña no funcionan:**
- Verifica que importaste el archivo `nexovoz.sql`
- Prueba con: correo `acostamorenodaniela6@gmail.com` y contraseña `12345`
