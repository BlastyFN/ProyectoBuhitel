const textoCINS = document.getElementById("CINText");
const textoCOTS = document.getElementById("COTText")
const textoDisponibilidad = document.getElementById("PorDisponibilidad");
// const textoTipos = document.getElementById("ContTipos");

window.addEventListener("load", cargarData);
function cargarData() {
    cargarChecks();
    // cargarDisponibilidad();
    // cargarTipos();
}

function cargarChecks() {
    fetch('../backend/consultarDisponibilidad.php', {
        method: 'POST'
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto){
        console.log(texto);
    })
    .catch(function(err) {
        console.log(err);
     });
}