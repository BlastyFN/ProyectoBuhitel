const titulo = document.querySelector('.titulo');
const nombrePersonal = document.querySelector('.nombre');
const tipoPersonal = document.querySelector('.tipoPersonal');
const correoPersonal = document.querySelector('.correo');
const passwordPersonal = document.querySelector('.password');
const seguroSocialPersonal = document.querySelector('.seguroSocial');



window.addEventListener('load', e => {
    fetch('../backendModuloPersonal/obtenerPersonalEspecifico.php' , {
        method:'POST'
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
            passwordPersonal.textContent = "Contraseña: " + element.Personal_Contrasena;
            seguroSocialPersonal.textContent = "Número de seguridad social: " + element.Personal_Seguro;
        }
    })
})

