const campoNombre = document.getElementById("NNombre");
const campoHotel = document.getElementById("NHotel");
const campoAPaterno = document.getElementById("NApellidoP");
const campoAMaterno = document.getElementById("NApellidoM");
const campoCorreo = document.getElementById("NCorreo");
const campoTelefono = document.getElementById("NTelefono");
const formulario = document.getElementById("NFormulario");
const btnActualizar = document.getElementById("btnActualizar");
const inputs = document.querySelectorAll('#NFormulario input');
const campoClave = document.getElementById("NClave1");
const campoConfirmarClave = document.getElementById("NClave2");
const btnConfirmar = document.getElementById("btnClave");

inputs.forEach((input)=> {
    input.addEventListener('keyup', Validacion);
    input.addEventListener('blur', Validacion);
}); 

function Validacion() {
    btnActualizar.disabled = false;
    inputs.forEach(campo => {
        if (campo.value == "") {
            btnActualizar.disabled = true;
        }
    });
}

window.addEventListener("load", function () {
    fetch ('../backend/obtenerDatosAdmin.php', {
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
        if (texto == "0") {

        }
        else{
            var informacion = JSON.parse(texto);
            console.log(informacion);
            campoNombre.value = informacion.Personal_Nombre;
            campoAPaterno.value = informacion.Personal_APaterno;
            campoAMaterno.value = informacion.Personal_AMaterno;
            campoCorreo.value = informacion.Personal_Correo;
            campoTelefono.value = informacion.Personal_Telefono;
            campoHotel.value = informacion.Hotel_Nombre;
        }
     })
     .catch(function(err) {
        console.log(err);
     }); 
});

btnActualizar.addEventListener("click", function (e) {
    e.preventDefault();
    const infoActualizar = new FormData(formulario);
    fetch ('../backend/nuevosDatosAdmin.php', {
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
        alert(texto);
     })
     .catch(function(err) {
        console.log(err);
     }); 
});

campoClave.addEventListener("keyup", verificarClave);
campoClave.addEventListener("blur", verificarClave);
campoConfirmarClave.addEventListener("keyup", verificarClave);
campoConfirmarClave.addEventListener("blur", verificarClave);

function verificarClave() {
    btnConfirmar.disabled = true;
    if (campoClave.value == campoConfirmarClave.value) {
        if (campoClave.value != "" && campoConfirmarClave.value != "") {
            console.log(campoClave.value + " " + campoConfirmarClave.value);
            btnConfirmar.disabled = false;
        }
    }

}

btnConfirmar.addEventListener("click", function () {
    const infoClave = new FormData();
    infoClave.append("Clave", campoClave.value);
    fetch ('../backend/cambiarClave.php', {
        method:'POST',
        body: infoClave
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        alert(texto);
     })
     .catch(function(err) {
        console.log(err);
     }); 
});