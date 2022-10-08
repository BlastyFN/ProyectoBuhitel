const formRegistroUsuario = document.querySelector('.formNuevoUsuario');
const formCambiarHorario = document.querySelector('.formCambiarHorario');

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

const inputInicioJornada = document.getElementById('inicioJornada');
const inputFinJornada = document.getElementById('finJornada');
const inputInicioDescanso = document.getElementById('inicioDescanso');
const inputFinDescanso = document.getElementById('finDescanso');

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
        verificarUsuariosLimpieza();
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
inputTipoPersonal.onchange(verificarUsuariosLimpieza());

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
    cambiarPassword.append('personalID',localStorage.getItem('personalID'));
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
        
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'El horario de limpiezas se ha modificado correctamente',
            showConfirmButton: false,
            timer: 2500
        }).then(()=>{
            window.location.href = "https://corporativotdo.com/Administrador/moduloPersonal/vistaGeneralUsuarios/vistaGeneralUsuarios.php";
        });
    })
})

//                          Cargar información usuario limpieza
window.addEventListener('load',e=>{
    const obtenerHorarios = new FormData();
    obtenerHorarios.append('personalID', localStorage.getItem('personalID'));
    fetch('../backendModuloPersonal/obtenerHorariosPersonal.php' , {
        method:'POST', body:obtenerHorarios
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(infoHorarios){
        console.log(infoHorarios);
        for(element of infoHorarios){
            inputInicioJornada.value = element.InfoLimpieza_InicioJornada;
            inputFinJornada.value = element.InfoLimpieza_FinJornada;
            inputInicioDescanso.value = element.InfoLimpieza_InicioDescanso;
            inputFinDescanso.value = element.InfoLimpieza_FinDescanso; 
        }
    })
})


//                          Modificar información usuario limpieza
formCambiarHorario.addEventListener('submit', function(e){
    e.preventDefault();    
    enviarRegistro.append('personalID', localStorage.getItem('personalID'));
    enviarRegistro.append('inicioJornada',inputInicioJornada.value);
    enviarRegistro.append('finJornada',inputFinJornada.value);
    enviarRegistro.append('inicioDescanso',inputInicioDescanso.value);
    enviarRegistro.append('finDescanso', inputFinDescanso.value);
 

    fetch('../backendModuloPersonal/modificarHorariosPersonal.php' , {
        method:'POST', body:enviarRegistro
    }).then(function(response){
        if(response.ok){
         return response.text();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(texto){
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'El personal se ha registrado correctamente',
            showConfirmButton: false,
            timer: 2500
        }).then(()=>{
            window.location.href = "https://corporativotdo.com/Administrador/moduloPersonal/vistaGeneralUsuarios/vistaGeneralUsuarios.php";
        });
    })
});

//                        Mostrar u ocultar modificacion horarios limpieza
function verificarUsuariosLimpieza(){
    if(inputTipoPersonal.value == "Limpieza"){
        formCambiarHorario.style.display = "flex";
    }
    else {
        formCambiarHorario.style.display = "none";
    }
}