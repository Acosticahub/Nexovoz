document.addEventListener("DOMContentLoaded", () => {

const modal = document.getElementById("modal");
const userBtn = document.getElementById("userBtn");

const btnFoto = document.getElementById("btnFoto");
const foto = document.getElementById("foto");
const preview = document.getElementById("preview");

const guardar = document.getElementById("guardar");
const cerrar = document.getElementById("cerrar");

/* ABRIR MODAL */
userBtn.onclick = () => {
    modal.style.display = "flex";
};

/* CERRAR */
cerrar.onclick = () => {
    modal.style.display = "none";
};

/* SUBIR FOTO */
btnFoto.onclick = () => foto.click();

foto.onchange = (e) => {
    const file = e.target.files[0];
    const reader = new FileReader();

    if(file){
        reader.onload = () => {
            preview.src = reader.result;
        };
        reader.readAsDataURL(file);
    }
};

/* GUARDAR */
guardar.onclick = () => {
    const data = {
        nombre: document.getElementById("nombre").value,
        correo: document.getElementById("correo").value,
        foto: preview.src
    };

    localStorage.setItem("usuario", JSON.stringify(data));
    alert("Guardado");
};

/* CARGAR DATOS */
const data = JSON.parse(localStorage.getItem("usuario"));

if(data){
    document.getElementById("nombre").value = data.nombre;
    document.getElementById("correo").value = data.correo;
    preview.src = data.foto;
    userBtn.src = data.foto;
}

});