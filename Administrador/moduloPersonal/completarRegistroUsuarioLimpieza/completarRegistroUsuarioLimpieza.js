const formRegistroUsuario = document.querySelector('.formNuevoUsuario');
const enviarRegistro = new FormData();

const inputInicioJornada = document.getElementById('inicioJornada');
const inputFinJornada = document.getElementById('finJornada');
const inputInicioDescanso = document.getElementById('inicioDescanso');
const inputFinDescanso = document.getElementById('finDescanso');
 

formRegistroUsuario.addEventListener('submit', function(e){
    e.preventDefault();    

    enviarRegistro.append('inicioJornada',inputFinJornada.value);
    enviarRegistro.append('finJornada',inputFinJornada.value);
    enviarRegistro.append('inicioDescanso',inputFinDescanso.value);
    enviarRegistro.append('finDescanso', inputFinDescanso.value);
 

    fetch('../backendModuloPersonal/registrarInfoUsuarioLimpieza.php' , {
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