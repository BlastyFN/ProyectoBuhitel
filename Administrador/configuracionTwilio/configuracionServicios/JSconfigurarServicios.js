const checkPrincipal = document.getElementById("cboxGeneral");
const checkServicios = document.getElementById("cboxServicio");
const checkLimpiezas = document.getElementById("cboxLimpiezas");
const checkValet = document.getElementById("cboxValet");
window.addEventListener("load", function () {
    cargarEstados();
});

function cargarEstados() {
    fetch ('../backend/obtenerDatos.php', {
        method:'POST'
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        console.log(texto);
        if (texto == "0") {

        }
        else{
            var informacion = JSON.parse(texto);
            console.log(informacion);
            setValor(checkPrincipal, informacion.Twilio_ChatBot);
            setValor(checkServicios, informacion.Twilio_Servicio);
            setValor(checkLimpiezas, informacion.Twilio_Limpieza);
            setValor(checkValet, informacion.Twilio_Valet);
        }
     })
     .catch(function(err) {
        console.log(err);
     }); 
}


function setValor(cbox, num) {
    if (num == 1) {
        cbox.checked = true;
    }
    else{
        if (num == 0) {
            cbox.checked = false;
        }
        else{
            console.log(cbox);
            console.log(num);
        }
    }
}

checkPrincipal.addEventListener("change", function () {
   cambiarEstado("Twilio_ChatBot", this);
});

checkServicios.addEventListener("change", function () {
    cambiarEstado("Twilio_Servicio", this);
 });

checkLimpiezas.addEventListener("change", function () {
    cambiarEstado("Twilio_Limpieza", this);
 });

checkValet.addEventListener("change", function () {
    cambiarEstado("Twilio_Valet", this);
 });



function cambiarEstado(campo, cbox) {
    var valor;
    if (cbox.checked) {
        valor = 1;
    }
    else{
        valor = 0;
    }
    const infoActualizar = new FormData();
    infoActualizar.append("Campo", campo);
    infoActualizar.append("Valor", valor);
    fetch ('../backend/nuevosDatos.php', {
        method:'POST',
        body: infoActualizar
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        console.log(texto);
     })
     .catch(function(err) {
        console.log(err);
     }); 
}