document.getElementById("formRegistro").addEventListener("submit", function(e) {
    e.preventDefault();

    let datos = new FormData(this);

    fetch("registro.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.text())
    .then(data => {
        document.getElementById("respuesta").innerHTML = data;

        if(data.includes("registrado")){
            setTimeout(() => {
                window.location = "login.html";
            }, 1500);
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
});