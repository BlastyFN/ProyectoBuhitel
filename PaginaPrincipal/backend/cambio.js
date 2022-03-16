const nuevaClave = document.getElementById('CampoNuevaClave');
const confirmarClave = document.getElementById('CampoConfirmarClave');
const botonCambio = document.getElementById('BotonCambiar');
const msjClave = document.getElementById('MsjClave1');
const msjConf = document.getElementById('MsjClave2');
const expresionClave = /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/; // 4 a 12 digitos. MAYUSCULAS; MINUSCULSA Y UN NUMERO
//Verifica que el campo de clave cumpla con los parámetros cada que se actualiza
nuevaClave.addEventListener('keyup', function() {
    //Compara con la expresión
    if (expresionClave.test(nuevaClave.value)) {
        //Quita el error y oculta el mensaje de error
        nuevaClave.classList.remove("Error");
        msjClave.classList.add("Oculto");
        //Verifica que la contraseña de confirmación coincida
        verificarIgualdad();
    }
    else{
        //Añade el error y revela el mensaje de error, deshabilita el botón
        nuevaClave.classList.add("Error");
        msjClave.classList.remove("Oculto");
        botonCambio.disabled = true;
    }
});
//Event listener que manda a verificar la igualdad entre los campos
confirmarClave.addEventListener('keyup', function () {
   verificarIgualdad(); 
});


//Campo que verifica que ambos campos coincidan
function verificarIgualdad() {
    if (nuevaClave.value == confirmarClave.value) {
        //Habilita el botón, remueve el error y oculta el mensaje
        botonCambio.disabled = false;
        confirmarClave.classList.remove("Error");
        msjConf.classList.add("Oculto");
    }
    else{
        //Deshabilita el boton, muestra error y revela el mensaje
        botonCambio.disabled = true;
        confirmarClave.classList.add("Error");
        msjConf.classList.remove("Oculto");
    }
}

botonCambio.addEventListener('click', function (e) {
   //AJAX
   e.preventDefault();
   const NClave = new FormData();
   //Añade la nueva contraseña al form data
   NClave.append('Clave', nuevaClave.value);
   fetch ('backend/nuevaClave.php', {
       method:'POST',
       body: NClave
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
       switch (texto) {
           //El servidor devuelve un error
           case '0':
               alert("Error")
               break;
           case '2':
               //El servidor ejecuta todo correctamente y envía a inicio de sesión
                console.log(texto);
                window.location.href="http://localhost/Buhitel/PaginaPrincipal/InicioSesion.php";
               break;
           default:
               break;
       }
    })
    .catch(function(err) {
       console.log(err);
    }); 
});