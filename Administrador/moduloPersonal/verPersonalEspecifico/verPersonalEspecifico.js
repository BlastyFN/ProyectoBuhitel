const titulo = document.querySelector('.titulo');
const nombrePersonal = document.querySelector('.nombre');
const tipoPersonal = document.querySelector('.tipoPersonal');
const correoPersonal = document.querySelector('.correo');
//const passwordPersonal = document.querySelector('.password');
const seguroSocialPersonal = document.querySelector('.seguroSocial');
const btnVolver = document.querySelector('.volver');
const btnModificar = document.querySelector('.modificar');
const btnEliminar = document.querySelector('.eliminar');
var obtenerUsuarioEspecífico = new FormData();


window.addEventListener('load', e => {
    obtenerUsuarioEspecífico.append("personalID",localStorage.getItem("personalID"));
    fetch('../backendModuloPersonal/obtenerPersonalEspecifico.php' , {
        method:'POST', body:obtenerUsuarioEspecífico
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(infoPersonal){
        console.log(infoPersonal);
        for(element of infoPersonal){
            titulo.textContent = "Mostrando la información de " + element.Personal_Nombre;
            nombrePersonal.textContent = "Nombre: " + element.Personal_Nombre + " " + 
            element.Personal_APaterno + " " + element.Personal_AMaterno;
            tipoPersonal.textContent = "Tipo de personal: " + element.Personal_Tipo;
            correoPersonal.textContent = "Correo: " + element.Personal_Correo;
            //passwordPersonal.textContent = "Contraseña: " + element.Personal_Contrasena;
            seguroSocialPersonal.textContent = "Número de seguridad social: " + element.Personal_Seguro;
        }
    })
})


btnVolver.addEventListener('click', e=>{
    window.location.href = "https://corporativotdo.com/Administrador/moduloPersonal/vistaGeneralUsuarios/vistaGeneralUsuarios.php";
})



btnModificar.addEventListener('click', e =>{
    window.location.href="https://corporativotdo.com/Administrador/moduloPersonal/modificarPersonal/modificarPersonal.php";
})

btnEliminar.addEventListener('click', ()=>{
    Swal.fire({
        title: '¿Estás seguro?',
        text: "El personal se eliminará permanentemente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            eliminarUsuario();
        }
    })
})

function eliminarUsuario(){
    const datosEliminarPersonal = new FormData();
    datosEliminarPersonal.append("personalID",localStorage.getItem("personalID"));
    fetch('../backendModuloPersonal/eliminarPersonal.php' , {
        method:'POST', body:datosEliminarPersonal
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(res){
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'El personal se ha eliminado correctamente',
            showConfirmButton: false,
            timer: 2500
        });
    })
}