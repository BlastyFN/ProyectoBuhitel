const formRegistroUsuario = document.querySelector('.formNuevoUsuario');
const enviarRegistro = new FormData();

const inputNombres = document.getElementById('nombreUsr');
const inputApellidoP = document.getElementById('apellidoP');
const inputApellidoM = document.getElementById('apellidoM');
const inputTipoPersonal = document.getElementById('tipoPersonal');
const inputCorreo = document.getElementById('correoUsr');
const inputContraseña = document.getElementById('password');
const inputSeguroSocial = document.getElementById('seguroSocial'); 

formRegistroUsuario.addEventListener('submit', function(e){
    e.preventDefault();    

    enviarRegistro.append('nombres',inputNombres.value);
    enviarRegistro.append('apellidoP',inputApellidoP.value);
    enviarRegistro.append('apellidoM',inputApellidoM.value);
    enviarRegistro.append('tipoPersonal', inputTipoPersonal.value);
    enviarRegistro.append('correo',inputCorreo.value);
    enviarRegistro.append('password',inputContraseña.value);
    enviarRegistro.append('seguroSocial',inputSeguroSocial.value);
   
    

    fetch('../backendModuloPersonal/registrarPersonal.php' , {
        method:'POST', body:enviarRegistro
    }).then(function(response){
        if(response.ok){
         return response.text();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(texto){
        console.log(texto);
        alert(texto);
    })
});