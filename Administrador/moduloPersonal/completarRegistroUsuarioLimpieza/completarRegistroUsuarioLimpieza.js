const formRegistroUsuario = document.querySelector('.formNuevoUsuario');
const enviarRegistro = new FormData();

const inputInicioJornada = document.getElementById('inicioJornada');
const inputFinJornada = document.getElementById('finJornada');
const inputInicioDescanso = document.getElementById('inicioDescanso');
const inputFinDescanso = document.getElementById('finDescanso');
 

formRegistroUsuario.addEventListener('submit', function(e){
    e.preventDefault();    

    enviarRegistro.append('inicioJornada',inputInicioJornada.value);
    enviarRegistro.append('finJornada',inputFinJornada.value);
    enviarRegistro.append('inicioDescanso',inputInicioDescanso.value);
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