const startBtn = document.getElementById("startBtn");
const testArea = document.getElementById("testArea");
const mic = document.querySelector(".mic");

let phase = 0;

const phases = [
    {
        title: "Prueba de pronunciación",
        text: "Repite: PERRO, RATÓN, ZAPATO, ESTRELLA"
    },
    {
        title: "Prueba de fluidez",
        text: "Lee: 'El gato corre rápidamente por el jardín.'"
    },
    {
        title: "Articulación espontánea",
        text: "Describe qué hiciste ayer."
    },
    {
        title: "Velocidad del habla",
        text: "Habla sobre tu comida favorita durante 10 segundos."
    }
];

startBtn.addEventListener("click", iniciarPrueba);

function iniciarPrueba() {
    solicitarMicrofono();
    mostrarFase();
}

function solicitarMicrofono() {
    navigator.mediaDevices.getUserMedia({ audio: true })
        .then(() => {
            document.getElementById("instructions").innerHTML = 
                "<p>Micrófono activado. Realiza las pruebas.</p>";
        })
        .catch(() => {
            alert("Debes permitir el uso del micrófono");
        });
}

function mostrarFase() {
    if (phase < phases.length) {
        testArea.innerHTML = `
            <h2>${phases[phase].title}</h2>
            <p>${phases[phase].text}</p>
            <button onclick="grabar()">🎤 Grabar</button>
        `;
    } else {
        mostrarResultado();
    }
}

function grabar() {
    mic.classList.add("active");

    setTimeout(() => {
        mic.classList.remove("active");
        phase++;
        mostrarFase();
    }, 3000); // simula grabación
}

function mostrarResultado() {
    const diagnostico     = "Posible dislalia (errores en pronunciación)";
    const recomendaciones = "Practicar lectura en voz alta, repetir palabras y controlar la respiración.";

    testArea.innerHTML = `
        <h2>Resultado</h2>
        <ul>
            <li>Posible dislalia (errores en pronunciación)</li>
            <li>Fluidez aceptable</li>
            <li>Articulación normal</li>
            <li>Velocidad ligeramente rápida</li>
        </ul>

        <h3>Recomendaciones</h3>
        <p>Practicar lectura en voz alta, repetir palabras y controlar la respiración.</p>

        <p style="color: yellow;">
        Este resultado es orientativo y no reemplaza un profesional.
        </p>

        <br>
        <button onclick="location.reload()" class="btn-home">Reiniciar</button>
    `;

    const datos = new FormData();
    datos.append('pronunciacion',   'Posible dislalia');
    datos.append('fluidez',         'Aceptable');
    datos.append('articulacion',    'Normal');
    datos.append('velocidad',       'Ligeramente rápida');
    datos.append('diagnostico',     diagnostico);
    datos.append('recomendaciones', recomendaciones);

    fetch('guardar_resultado.php', { method: 'POST', body: datos });
}