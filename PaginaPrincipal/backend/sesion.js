const formularioSesion = document.getElementById('FormularioIS');
const Correo = document.getElementById('CampoCorreo');
const Clave = document.getElementById('CampoClave');
const MsjClave = document.getElementById('MsjClave');
const MsjCorreo = document.getElementById('MsjCorreo');
const boton = document.getElementById('BotonIniciar');

//Alternadores de habilitación del botón

Correo.addEventListener('keyup', function() {
   if (this.value!="") {
       if (Clave.value!="") {
            boton.disabled = false;
       }
       else{
        boton.disabled = true;
        }
   }
   else{
    boton.disabled = true;
    }
});

Clave.addEventListener('keyup', function() {
    if (this.value!="") {
        if (Correo.value!="") {
            boton.disabled = false;
        }
        else{
            boton.disabled = true;
        }
    }
    else{
        boton.disabled = true;
    }
 });
 
//EVENT LISTENER DE BOTON PRESIONADO
boton.addEventListener('click', function(e) {
    e.preventDefault();
    //VERIFICAR
    const infoSesion = new FormData(formularioSesion);
    fetch('backend/consultaSesion.php', {
        method:'POST',
        body: infoSesion
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        switch (texto) {
            // 0 ES QUE NO SE ENCONTRÓ EL CORREO
            case '0':
                console.log("Correo no encontrado");
                Clave.value="";
                Correo.classList.add("Error");
                MsjCorreo.classList.remove("Oculto");
                break;
                //1 ES QUE LA CONTRASEÑA ES INCORRECTA
            case '1':
                console.log("Contraseña incorrecta");
                Correo.classList.remove("Error");
                MsjCorreo.classList.add("Oculto");
                Clave.classList.add("Error");
                MsjClave.classList.remove("Oculto");
                break;  
                //DEVOLVIÓ EL JSON CORRECTAMENTE
            default:
                console.log("Sesion valida");
                console.log(texto);
                //Lo hace en arreglo de JSONS
                const infoPersonal = JSON.parse(texto);
                console.log(infoPersonal);
                //ENVÍA A REDIRECCIONAR CON EL OBJETO DE PARAMETRO
                guardarInfo(infoPersonal);
                
                break;
        }
     })
     .catch(function(err) {
        console.log(err);
     });
});

function redireccionar(Personal) {
    //CREA LA URL BASE
    var URL = "http://corporativotdo.com/";
    console.log(Personal.Personal_Tipo);
    //SEGUN CADA CASO LE AÑADE LA DIRECCIÓN QUE SIGUE
    switch (Personal.Personal_Tipo) {
        case "Administrador":
            URL=URL+"Administrador/pagina principal admin/pagPrincipalAdmin.php";
            break;
        case "Recepcion":
            URL=URL+"Recepcion/Reservacion/ConsultarReservaciones/ConsultaReservaciones.php";
            break;
        case "Limpieza":
            
            break;
        case "Valet":
            URL=URL+"ValetParking/Vehiculos/VisualizarVehiculos/AgregarVehiculos.php";
            break;
        case "Servicio":
            URL=URL+"Servicio/ConsultarServicios/VisualizarPedidos/GestionarPedidos.php";
            break;    
       default:
            URL=URL+"/index.php";
            break;
    }
    console.log(URL);
    //ENVÍA A LA DIRECCIÓN
    window.location.href=URL;
}

function guardarInfo(Info) {
    miStorage = window.localStorage;
    if (storageAvailable("miStorage")) {
        console.log("DisponibleMS");
    }
    if (storageAvailable("localStorage")) {
        console.log("DisponibleMS");
    }
   
    miStorage.setItem("ID", Info.Personal_ID);
    miStorage.setItem("Hotel", Info.Personal_Hotel);
    miStorage.setItem("Nombre", Info.Personal_Nombre);
    miStorage.setItem("Tipo", Info.Personal_Tipo);
    miStorage.setItem("Correo", Correo.value);
    redireccionar(Info);
}