//CAMPOS
const CampoNombre = document.getElementById('CampoNombre');
const CampoApellidos = document.getElementById('CampoApellidos');
const CampoContacto = document.getElementById('CampoContacto');
const Campo_CheckIn = document.getElementById('Campo_CHECKIN');
const Campo_CheckOut = document.getElementById('Campo_CHECKOUT');
const PTOTAL = document.getElementById('PrecioTotal');

//BOTONES
const btnAddHabitaciones = document.getElementById('addInput');
const btnEditarHabitaciones = document.getElementById('EditarHab');
const btnEditarHuesped = document.getElementById('EditarHues');
//DIVISIONES
const contenedor = document.querySelector('#Entradas'); 
//INFOGLOBAL
var Editable;
var statusInicial;
var STipos;
var SHabitaciones;
var HID;
var TiposH;
var HabitacionesCargadas;
var contadorLineas = 0;
window.addEventListener('load', function (e) {
    const ReservacionID = new FormData();
    Editable = this.localStorage.Editar;
    console.log(Editable);
    ReservacionID.append('Reservacion', Editable);
    fetch('../backend/consultarReservacion.php', {
        method:'POST',
        body: ReservacionID
    })
    .then(function(response) {
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        
        const infoRecibida = JSON.parse(texto);
        console.log(infoRecibida);
        CampoNombre.value=infoRecibida.Huesped_Nombre;
        CampoApellidos.value = infoRecibida.Huesped_Apellidos;
        CampoContacto.value = infoRecibida.Huesped_Contacto;
        Campo_CheckIn.value = infoRecibida.Reservacion_CheckIn.replace(/\s+/g, 'T');
        Campo_CheckOut.value = infoRecibida.Reservacion_CheckOut.replace(/\s+/g, 'T');
        HID = infoRecibida.Reservacion_Huesped;
       
        cargarTipos();
        cargarHabitaciones(Editable);
        statusInicial = true;
    })
    .catch(function(err) {
        console.log(err);
    });
});



CampoNombre.addEventListener('keyup', HabilitarBtnHuesped);
CampoApellidos.addEventListener('keyup', HabilitarBtnHuesped);
CampoContacto.addEventListener('keyup', HabilitarBtnHuesped);
function HabilitarBtnHuesped() {
    if (CampoNombre.value!="" && CampoApellidos.value !="" && CampoContacto.value != "" ) {
        btnEditarHuesped.disabled = false;
    }
    else{
        btnEditarHuesped.disabled = true;
    }
}

btnEditarHuesped.addEventListener('click', function (e) {
    e.preventDefault();
    

    const NuevoHuesped = new FormData();
    NuevoHuesped.append('Nombre', CampoNombre.value);
    NuevoHuesped.append('Apellidos', CampoApellidos.value);
    NuevoHuesped.append('Contacto', CampoContacto.value);
    NuevoHuesped.append('Huesped', HID);
    fetch('../backend/actualizarHuesped.php', {
        method:'POST',
        body: NuevoHuesped
    })
    .then(function(response) {
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        window.location.href="http://localhost/Buhitel/Recepcion/Reservacion/ConsultarReservaciones/ConsultaReservaciones.php";
    })
    .catch(function(err) {
        console.log(err);
    });

});

function cargarHabitaciones(resAEdit) {
    const HabsReservacion = new FormData();
    HabsReservacion.append('Reservacion', resAEdit);
    fetch('../backend/consultaHabsEdit.php', {
        method:'POST',
        body: HabsReservacion
        
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto){
        HabitacionesCargadas = JSON.parse(texto);
        console.log(HabitacionesCargadas);
        HabitacionesCargadas.forEach(element => {
            crearLinea(contadorLineas);
        });
    })
    .catch(function(err) {
        console.log(err);
     });
}



function cargarTipos() {
    fetch('../backend/consultaTipos.php', {
        method: 'POST'
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto){
        TiposH = JSON.parse(texto);
        console.log(TiposH);
    })
    .catch(function(err) {
        console.log(err);
     });
}

function crearLinea(numero) {
    //Declaración de elementos basicos
    contadorLineas = contadorLineas+1;
    const iHabitacion = document.createElement('select');
    const br = document.createElement('br'); 
    //Agregar clases a la habitación
    iHabitacion.classList.add('EntradaTexto');
    iHabitacion.classList.add('Mitad');
    iHabitacion.classList.add('SHabitacion');
    //Agregar atributos a habitación
    iHabitacion.setAttribute("placeholder", "Habitación");
    iHabitacion.setAttribute("name", "Habitacion"+(numero));
   //Agregar SELECT TIPO
    const iTipo = document.createElement('select');
   //Clases SELECT TIPO
    iTipo.classList.add('EntradaTexto');
    iTipo.classList.add('Mitad');
    iTipo.classList.add('STipo');
   //Atributos SELECT TIPO
    iTipo.setAttribute("name", "Tipo"+(numero));
   //Agregar opciones tipo
   crearOpciones(TiposH, iTipo);
   //Agregar opciones habitaciones
    var habitaciones;
    const infoPTipo = new FormData();
    infoPTipo.append('Tipo', TiposH[0].TipoHab_ID);
    infoPTipo.append('CIN', Campo_CheckIn.value);
    infoPTipo.append('COUT', Campo_CheckOut.value);
    fetch ('../backend/consultaHabitaciones.php', {
        method:'POST',
        body: infoPTipo
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto){
        // console.log(texto);
        switch (texto) {
            case "1":
                alert("Error en la verificación del hotel");
                break;
            case "0":
                alert("No hay habitaciones disponibles");
                break;
            default:
                // console.log(texto);
                habitaciones = JSON.parse(texto);
                crearOpciones(habitaciones, iHabitacion);
                //Agregar elementos
                contenedor.appendChild(iTipo);
                contenedor.appendChild(iHabitacion);
                contenedor.appendChild(br);
                STipos = document.querySelectorAll('.STipo');
                SHabitaciones = document.querySelectorAll('.SHabitacion');
                if (statusInicial) {
                    asignarHabitaciones(numero, iTipo, iHabitacion);
                }
                iTipo.addEventListener('change', cambiarOpciones);
                // validarFechas();
                break;
        }
    })
    .catch(function(err) {
        console.log(err);
     }); 


}

function crearOpciones(Opciones, iSelect) {
    for (let index = 0; index < Opciones.length; index++) {
        const opcionHab = Opciones[index];
        //Crea la opcion
        const iOpcion = document.createElement('option');
        //Añade el valor de la opción
        
            
        
        //Añade el texto a mostrar de la opcion
            var iOpcionTexto;
            if (opcionHab.TipoHab_Nombre == undefined) {
                iOpcionTexto = document.createTextNode(opcionHab.Habitacion_Nombre);
                iOpcion.setAttribute("value", opcionHab.Habitacion_ID);
            }
            else{
                iOpcionTexto = document.createTextNode(opcionHab.TipoHab_Nombre);
                iOpcion.setAttribute("value", opcionHab.TipoHab_ID);
            }
            
            //Añade el texto de la opcion a la opcion
            iOpcion.appendChild(iOpcionTexto);
        
        //Añade la opción al SELECT Tipo
        iSelect.appendChild(iOpcion);   
    }
}


function asignarHabitaciones(indice, Tipo, Habitacion) {
    // Tipo.cambiarOpciones();
    console.log(HabitacionesCargadas[indice].TipoHab_Nombre);
    console.log(Habitacion);
    Tipo.value = HabitacionesCargadas[indice].Habitacion_Tipo;
    const iOpcion = document.createElement('option');
    iOpcion.setAttribute("value", HabitacionesCargadas[indice].Habitacion_ID);
    iOpcion.appendChild(document.createTextNode(HabitacionesCargadas[indice].Habitacion_Nombre));
    
    
    
    if (Tipo.value != TiposH[0].TipoHab_ID) {
        for (let i = Habitacion.length; i >= 0; i--) {
            Habitacion.remove(i);
        }
    }
    Habitacion.appendChild(iOpcion);
    Habitacion.value = HabitacionesCargadas[indice].Habitacion_ID;
    // Habitacion.value=HabitacionesCargadas[indice].Habitacion_Nombre;
    // document.querySelectorAll('STipo').forEach(element => {
    //     element.value = element.index;
    //     console.log(element.index);
    // });
}

function cambiarOpciones() {
    const SelectOpciones = this.nextSibling;
    const TipoNuevo = this.value;
    console.log(TipoNuevo);
        for (let i = this.options.length; i >= 0; i--) {
            SelectOpciones.remove(i);
        }
    console.log(SelectOpciones);
    //AJAX
    const infoNTipo = new FormData();
    infoNTipo.append('Tipo', TipoNuevo);
    infoNTipo.append('CIN', Campo_CheckIn.value);
    infoNTipo.append('COUT', Campo_CheckOut.value);
    fetch ('../backend/consultaHabitaciones.php', {
        method:'POST',
        body: infoNTipo
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto){
        console.log(texto);
        switch (texto) {
            case "1":
                alert("Error en la verificación del hotel");
                break;
            case "0":
                alert("No hay habitaciones disponibles");
                break;
            default:
                const NuevasHabitaciones = JSON.parse(texto);
                crearOpciones(NuevasHabitaciones, SelectOpciones);
                // validarFechas();
                break;
        }
    })
    .catch(function(err) {
        console.log(err);
     }); 
}

btnAddHabitaciones.addEventListener('click', function(e) {
   e.preventDefault(); 
   statusInicial = false;
   if (contadorLineas<5) {
    crearLinea(contadorLineas);
   }
   
});

Campo_CheckIn.addEventListener('change', validarFechas);
Campo_CheckOut.addEventListener('change', validarFechas);
Campo_CheckOut.addEventListener('change', borrarLineas);
Campo_CheckIn.addEventListener('change', borrarLineas);

function borrarLineas() {
    STipos.forEach(element => {
        element.remove();
    });
    SHabitaciones.forEach(element =>{
        element.remove();
    });
    contadorLineas = 0;
    var BR = contenedor.querySelectorAll('br');
    BR.forEach(element =>{
        element.remove();
    });
    PTOTAL.innerText = "$0";
}

function validarFechas(){
    
    var FCheckIn = new Date(Campo_CheckIn.value);
    var FCheckOut = new Date(Campo_CheckOut.value);
    FCheckIn.setHours(0,0,0,0);
    FCheckOut.setHours(0,0,0,0);
    if (FCheckOut>FCheckIn) {
        const dias = Math.abs(FCheckOut-FCheckIn)/(86400000);
        btnAddHabitaciones.disabled = false;
        // determinarPrecio(dias);
        revisarBoton();
        
    }else{
        if (FCheckOut!="Invalid Date" && FCheckIn!="Invalid Date") {
            alert("Error, el checkout debe ser mayor al checkin");
        }
        PTOTAL.innerText = "$0";
        btnAddHabitaciones.disabled = true;
        btnEditarHabitaciones.disabled = true;
    }
    
}

function revisarBoton(){
    if (SHabitaciones.length>0) {
        btnEditarHabitaciones.disabled = false;
        console.log("habilitar");
    }
    else{
        btnEditarHabitaciones.disabled = true;
        console.log("Deshabilitar");
    }
}

btnEditarHabitaciones.addEventListener('click', function (e) {
    e.preventDefault();
    actualizarFechas();
    alert(SHabitaciones.length);

});

function actualizarFechas() {
    statusInicial = false;
    const infoActualizar = new FormData();
    infoActualizar.append('Reservacion', Editable);
    infoActualizar.append('CIN', Campo_CheckIn.value);
    infoActualizar.append('COUT', Campo_CheckOut.value);
    fetch('../backend/actualizarFechas.php', {
        method:'POST',
        body: infoActualizar
        
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto){
        registrarHabitaciones(Editable);
    })
    .catch(function(err) {
        console.log(err);
     });
}

function registrarHabitaciones(Reservacion) {
    SHabitaciones.forEach(element => {
        const infoHabitacion = new FormData();
        infoHabitacion.append('Habitacion', element.value);
        infoHabitacion.append('Reservacion', Reservacion);
        fetch ('../backend/reservarHabitacion.php', {
            method:'POST',
            body: infoHabitacion
        })
        .then(function(response){
            if(response.ok) {
                return response.text();
            } else {
                throw "Error en la llamada Ajax";
            }
        })
        .then(function(texto){
            console.log(texto);
            switch (texto) {
                case "1":
                    console.log(texto);
                    reiniciarCampos();
                    break;
                case "0":
                    alert("Problema de registro");
                    break;
                default:
                    alert(texto);
                    break;
            }
        })
        .catch(function(err) {
            console.log(err);
         }); 
    });
    window.location.href="http://localhost/Buhitel/Recepcion/Reservacion/ConsultarReservaciones/ConsultaReservaciones.php";
}