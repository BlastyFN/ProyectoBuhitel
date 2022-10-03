const formRegistroUsuario = document.querySelector('.formNuevoServicio');
const enviarRegistro = new FormData();

const inputNombre = document.getElementById('nombre');
const inputTipo = document.getElementById('tipo');
const inputPrecio = document.getElementById('precio');
const inputDescripcion = document.getElementById('descripcion');


formRegistroUsuario.addEventListener('submit', function(e){
    e.preventDefault();    

    enviarRegistro.append('nombre',inputNombre.value);
    enviarRegistro.append('tipo',inputTipo.value);
    enviarRegistro.append('precio',inputPrecio.value);
    enviarRegistro.append('descripcion',inputDescripcion.value);

   
    

    fetch('../backendModuloServicios/registrarServicio.php' , {
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
            window.location.href = "https://corporativotdo.com/Administrador/moduloServicios/vistaGeneralServicios/vistaGeneralServicios.php";
        });
    })
});