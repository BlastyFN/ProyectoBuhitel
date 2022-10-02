const formRegistroUsuario = document.querySelector('.formNuevoUsuario');
const formCambiarPassword = document.querySelector('.cambiarPassForm');
const btnCambiarPass = document.querySelector('.btnCambiarPass');
const enviarRegistro = new FormData();
const cambiarPassword = new FormData();

const inputNombres = document.getElementById('nombreUsr');
const inputApellidoP = document.getElementById('apellidoP');
const inputApellidoM = document.getElementById('apellidoM');
const inputTipoPersonal = document.getElementById('tipoPersonal');
const inputCorreo = document.getElementById('correoUsr');
const inputContraseña = document.getElementById('password');
const inputSeguroSocial = document.getElementById('seguroSocial'); 
const confirmPassword = document.getElementById('confirmPassword');

window.addEventListener('load',e=>{
    const obtenerPersonal = new FormData();
    obtenerPersonal.append('personalID', localStorage.getItem('personalID'));
    fetch('../backendModuloPersonal/obtenerPersonalEspecifico.php' , {
        method:'POST', body:obtenerPersonal
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(infoPersonal){
        console.log(infoPersonal);
        for(element of infoPersonal){
            inputNombres.value = element.Personal_Nombre;
            inputApellidoP.value = element.Personal_APaterno 
            inputApellidoM.value = element.Personal_AMaterno;
            inputTipoPersonal.value = element.Personal_Tipo;
            inputCorreo.value = element.Personal_Correo;
            //inputContraseña.value = element.Personal_Contrasena;
            inputSeguroSocial.value = element.Personal_Seguro;
        }
    })
})

formRegistroUsuario.addEventListener('submit', function(e){
    e.preventDefault();    
    enviarRegistro.append('personalID',localStorage.getItem('personalID'));
    enviarRegistro.append('nombres',inputNombres.value);
    enviarRegistro.append('apellidoP',inputApellidoP.value);
    enviarRegistro.append('apellidoM',inputApellidoM.value);
    enviarRegistro.append('tipoPersonal', inputTipoPersonal.value);
    enviarRegistro.append('correo',inputCorreo.value);
    enviarRegistro.append();
    enviarRegistro.append('seguroSocial',inputSeguroSocial.value);
   
    

    fetch('../backendModuloPersonal/modificarPersonal.php' , {
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

inputContraseña.addEventListener("keyup", verificarClave);
inputContraseña.addEventListener("blur", verificarClave);
confirmPassword.addEventListener("keyup", verificarClave);
confirmPassword.addEventListener("blur", verificarClave);

function verificarClave() {
    btnCambiarPass.disabled = true;
    if (inputContraseña.value == confirmPassword.value) {
        if (inputContraseña.value != "" && confirmPassword.value != "") {
            //console.log(campoClave.value + " " + confirmPassword.value);
            btnCambiarPass.disabled = false;
        }
    }

}


formCambiarPassword.addEventListener('submit', (e)=>{
    e.preventDefault();
    enviarRegistro.append('personalID',localStorage.getItem('personalID'));
    cambiarPassword.append('password',inputContraseña.value);
    cambiarPassword.append('confirmPassword',confirmPassword.value);
    
     fetch('../backendModuloPersonal/modificarPasswordPersonal.php' , {
        method:'POST', body:cambiarPassword
    }).then(function(response){
        if(response.ok){
         return response.text();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(texto){
        
        alert(texto);
    })
})