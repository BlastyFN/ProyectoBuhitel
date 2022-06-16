const textoCINS = document.getElementById("CINText");
const textoCOTS = document.getElementById("COTText")
const textoDisponibilidad = document.getElementById("PorDisponibilidad");
const listaTipos = document.getElementById("ListaDisponibles");

window.addEventListener("load", cargarData);
function cargarData() {
    cargarChecks();
    cargarDisponibilidad();
    // cargarTipos();
}

function cargarDisponibilidad() {
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
        let numero = parseFloat(texto)*100;
        let porcentaje = 100-numero;
        
        let porstring = String(porcentaje);
        let punto = porstring.indexOf(".");
        let Stfinal = porstring.substring(0, punto+3);
        textoDisponibilidad.innerHTML=Stfinal+ "%"
        console.log(Stfinal);
    })
    .catch(function(err) {
        console.log(err);
     });
}

function cargarChecks() {
    fetch('../backend/consultarChecks.php', {
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
        var Checks;
        Checks = JSON.parse(texto);
        console.log(Checks);
        textoCINS.innerHTML = Checks.CINS + " Check-Ins pendientes para hoy";
        textoCOTS.innerHTML = Checks.COTS + " Check-Outs pendientes para hoy";

    })
    .catch(function(err) {
        console.log(err);
     });
}

function cargarTipos() {
    fetch('../backend/consultarTipos.php', {
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

    })
    .catch(function(err) {
        console.log(err);
     });
}