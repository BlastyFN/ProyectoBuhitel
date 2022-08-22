const formularioRegistro = document.getElementById('formularioReg');
const inputs = document.querySelectorAll('#formularioReg input');
const boton = document.getElementById('BotonRegistrar');
//Formulario confirmación
const ContenedorCon = document.getElementById('Confirmador');
const BotonCon = document.getElementById('BotonConfirmar');
const Codigo = document.getElementById('CampCodigo');
const correoDesplegado = document.getElementById('CorreoDesplegado');
const BotonCancelar = document.getElementById('BotonCancelar');
const subcontenedorCon = document.getElementById('SubContenedorCon');
//EXPRESIONES DE COMPARACIÓN PARA VALIDACIÓN
const expresiones = {
	hotel: /^[a-zA-Z0-9\_\-]{1,25}$/, // Letras, numeros, guion y guion_bajo
	nombre: /^[a-zA-ZÀ-ÿ\s]{1,20}$/, // Letras y espacios, pueden llevar acentos.
	password: /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/, // 4 a 12 digitos. MAYUSCULAS; MINUSCULSA Y UN NUMERO
	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/, //CORREO
	telefono: /^\d{10}$/ // IENE QUE SER DE 10 NUMEROS
}

//FUNCIÓN QUE CLASIFICA EL INPUT A VALIDAR

const Validacion = (e) =>{
    switch(e.target.name){
        case "Nombre":
            validarCampo(expresiones.nombre, e.target, 'Nombre');
        break;
        case "PApellido":
            validarCampo(expresiones.nombre, e.target, 'PApellido');
        break;
        case "SApellido":
            validarCampo(expresiones.nombre, e.target, 'SApellido');
        break;
        case "Correo":
            validarCampo(expresiones.correo, e.target, 'Correo');
        break;
        case "Telefono":
            validarCampo(expresiones.telefono, e.target, 'Telefono');
        break;
        case "Hotel":
            validarCampo(expresiones.hotel, e.target, 'Hotel');
        break;
        case "Contrasena":
            validarCampo(expresiones.password, e.target, 'Contrasena');
            validarCoincidencias();
        break;
        case "SegundaContrasena":
            validarCoincidencias();
        break;
    }
    
}

//FUNCIÓN QUE VALIDA Y ALTERNA EL ERROR

const validarCampo = (expresion, input, campo) => {

    //IF QUE COMPARA LA EXPRESIÓN CON EL VALOR DEL INPUT
    if(expresion.test(input.value)){
        //QUITAR ERROR
        document.getElementById(`campo_${campo}`).classList.remove('Error');
		document.getElementById(campo).classList.add('Oculto');
        //AÑADE CHECK SI ES LA PRIMERA VEZ QUE SE EDITA
        if (!document.getElementById(`campo_${campo}`).classList.contains('Check')) {
            document.getElementById(`campo_${campo}`).classList.add('Check');
        }
        //REVISA SI SE PUEDE HABILITAR EL BOTON
        revisarBoton();
		
	} else {
        //AÑADIR ERROR
		document.getElementById(`campo_${campo}`).classList.add('Error');
		document.getElementById(campo).classList.remove('Oculto');
        boton.disabled = true;
		
	}
}
//FUNCIÓN QUE VALIDA QUE LAS CONTRASEÑAS SEAN IGUALES
function validarCoincidencias() {
    //DELCARACIÓN DE AMBOS INPUTS
    const primeraClave = document.getElementById('campo_Contrasena');
    const segundaClave = document.getElementById('campo_SegundaContrasena');
    const mensaje = document.getElementById('SegundaContrasena');
    //IF QUE COMAPARA LOS INPUTS
    if (primeraClave.value == segundaClave.value) {
        //QUITAR EL ERROR
        segundaClave.classList.remove('Error');
        
        mensaje.classList.add('Oculto');
        //AÑADE CHECK SI ES LA PRIMERA VEZ QUE SE EDITA
        if (!segundaClave.classList.contains('Check')) {
            segundaClave.classList.add('Check');
        }
        //REVISA SI SE PUEDE HABILITAR EL BOTON
        revisarBoton();
    }
    else{
        //AGREGAR EL ERROR
        segundaClave.classList.add('Error');
        mensaje.classList.remove('Oculto')        
        boton.disabled = true;
    }
}
//GENERA DOS EVENT LISTENER PARA CADA INPUT
inputs.forEach((input)=> {
    input.addEventListener('keyup', Validacion);
    input.addEventListener('blur', Validacion);
}); 

//VERIFICADOR DE BOTON

function revisarBoton() {
    //SI YA SE HAN EDITADO TODOS HABILITA EL BOTON
    let Editados = document.querySelectorAll('.Check');
    if (Editados.length == 8) {
        boton.disabled = false;
    }
    
}


//EVENT LISTENER DE BOTON PRESIONADO
boton.addEventListener('click', function(e) {
    e.preventDefault();

    //COMPROBAR LUEGO REGISTRAR O ERROR

    //VERIFICAR
    const datoCorreo = new FormData();
    const inputCorreo = document.getElementById('campo_Correo');
    const valorCorreo = inputCorreo.value;
    datoCorreo.append('Correo', valorCorreo);
    fetch('backend/consultaCorreo.php', {
        method:'POST',
        body: datoCorreo
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        if (texto == '0') {
            
            //Mandar correo
            //Desplegar ventana de confirmación
            enviarCorreo(valorCorreo);
            desplegarConfirmador();
 
        }
        else{
            //ERROR
            inputCorreo.classList.add('Error');
            document.getElementById('Correo').classList.remove('Oculto');
            boton.disabled = true;

        }
     })
     .catch(function(err) {
        console.log(err);
     });
 
});
//FUNCIÓN QUE LLAMA EL PHP DE MANDAR CORREO Y ABRE EL POPUP

function registrar() {
    //REGISTRAR PRIMERO HOTEL; OBTENER ID CON EL CORREO QUE TIENE EN COMUN Y REGISTRAR USUARIO CON EL ID DEL HOTEL
    //AJAX
    const info = new FormData(formularioRegistro);
    //Agregar codigo de confirmación a información enviada
    info.append('Codigo', Codigo.value);
    fetch ('backend/registrarOriginal.php', {
        method:'POST',
        body: info
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
            case '0':
                //Servidor responde que código no coincide
                alert("Código incorrecto")
                break;
            case '1':
                //Servidor responde que código coincide
                alert("Registro completado con éxito");
                //Limpia el formulario
                limpiar();

                const correoFirebase = document.getElementById('campo_Correo');
                const contrasenaFirebase = document.getElementById('campo_Contrasena');

                firebase.auth().createUserWithEmailAndPassword(correoFirebase.value, contrasenaFirebase.value)
                .catch((error) => {
                    var errorCode = error.code;
                    var errorMessage = error.message;
                    // ..
                });
                //Repliega el formulario de confirmación
                replegarConfirmador();
                break;
            default:
                break;
        }
     })
     .catch(function(err) {
        console.log(err);
     });
} 


function limpiar() {
    inputs.forEach((input)=> {
        input.value="";
    }); 
}


Codigo.addEventListener('keyup', function(e) {
    console.log(this.value.length);
    if (this.value.length!=6) {
        BotonCon.disabled = true;
        
    }
    else{
        BotonCon.disabled = false;
    }
    
});

BotonCon.addEventListener('click', function (e) {
   e.preventDefault();

        registrar();
});

function desplegarConfirmador(){
    //Oculta el formulario de registro y revela el de confirmación
    subcontenedorCon.classList.remove("Oculto");
    formularioRegistro.classList.add("Oculto");
}

BotonCancelar.addEventListener('click', function (e) {
   replegarConfirmador();
});

function replegarConfirmador(){
    subcontenedorCon.classList.add("Oculto");
    formularioRegistro.classList.remove("Oculto");
}

function enviarCorreo(email){
    const datoCorreo = new FormData();
    datoCorreo.append('Correo', email);
    fetch ('backend/correoConfirmar.php', {
        method:'POST',
        body: datoCorreo
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
        alert(err);
     });
}