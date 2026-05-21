document.getElementById("formLogin").addEventListener("submit", function(e) {
    e.preventDefault();

    let datos = new FormData(this);

    fetch("login.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.text())
    .then(data => {
        if(data === "ok"){
            window.location = "dashboard.php";
        } else {
            document.getElementById("respuesta").innerHTML = data;
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
});