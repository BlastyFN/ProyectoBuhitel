const Formulario = document.getElementById('FormularioR');
const inputCorreo = document.getElementById('CampoCorreoR');
const inputCodigo = document.getElementById('CampoClaveR')
const errorCorreo = document.getElementById('MsjCorreoR');
const errorClave = document.getElementById('MsjClaveR');
const btnCorreo = document.getElementById('BotonCorreo');
const btnClave = document.getElementById('BotonClave');


//Habilita el boton si el campo no está vacío
inputCorreo.addEventListener('keyup', function () {
    if (inputCorreo.value!='') {
        btnCorreo.disabled = false;
    }
});

//Envía la dirección de correo para verificar que esté registrado en el sistema
btnCorreo.addEventListener('click', function (e) {
    e.preventDefault();
    const datoCorreo = new FormData();
    const valorCorreo = inputCorreo.value;
    //Añade el valor de correo
    datoCorreo.append('Correo', valorCorreo);
    fetch('backend/consultaCorreo.php', {
        method:'POST',
        body: datoCorreo
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            alert("error");
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        console.log(texto);
        if (texto == '0') {
            //ERROR, Correo no encontrado
            inputCorreo.classList.add('Error');
            errorCorreo.classList.remove('Oculto')
        }
        else{
            //Correo encontrado
            //Oculta el campo de correo y le quita el error
            inputCorreo.classList.remove('Error');
            errorCorreo.classList.add('Oculto');
            //Envía el correo con la dirección como parámetro
            enviarCorreo(inputCorreo.value);
            //Avanza en el formulario
            sigPaso();
        }
     })
     .catch(function(err) {
        console.log(err);
     });
    
});
//Verifica que estén 6 caracteres en el campo 
inputCodigo.addEventListener('keyup', function (e) {
    console.log(e.value);
   if (this.value.length!=6) {
       //Deshabilita el botón
       btnClave.disabled = true;
   }
   else{
       //Habilita el botón
    btnClave.disabled = false;
   }
});
//Función que avanza en el formulario
function sigPaso() {
    //Desaparecer la fase de correo
    btnCorreo.disabled = true;
    inputCorreo.classList.add("Oculto");
    btnCorreo.classList.add("Oculto");
    //Aparecer la fase de codigo
    inputCodigo.classList.remove("Oculto");
    btnClave.classList.remove("Oculto");
}
//Función que envió el correo
function enviarCorreo(email){
    const correoCuenta = new FormData();
    //Añade el valor del correo
    correoCuenta.append('Correo', email);
    fetch ('backend/correoRecuperar.php', {
        method:'POST',
        body: correoCuenta
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
     })
     .catch(function(err) {
        console.log(err);
     });
}
//Click en el botón de verificar el código de confirmación
btnClave.addEventListener('click', function(e){
    e.preventDefault();
    //Manda a la función AJAX el valor del campo del código
    validarCodigo(inputCodigo.value);
    
});
//Función AJAX que envía el código de confirmación para su validación
function validarCodigo(Codigo) {
    const codigoRecuperacion = new FormData();
    codigoRecuperacion.append('Codigo', Codigo);
    fetch ('backend/validarCodigo.php', {
        method:'POST',
        body: codigoRecuperacion
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        //El servidor devuelve que el código coincide
        if(texto == '1'){
            alert("Codigo Confirmado");
            //Redirecciona al cambio de contraseña
            window.location.href="https://corporativotdo.com/PaginaPrincipal/cambiarContrasena.php";
        }
        else{
            //El servidor devuelve error
            alert(texto);
        }

     })
     .catch(function(err) {
        console.log(err);
     });
}