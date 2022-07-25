const btnAdd = document.querySelector('#addImput'); //Obtiene el botón añadir
const contenedor = document.querySelector('#Entradas');  //Obtiene el div en el que están las entradas
const PTOTAL = document.getElementById('PrecioTotal');
const Check_In = document.getElementById('Campo_CHECKIN');
const Check_Out = document.getElementById('Campo_CHECKOUT');
const CNombre = document.getElementById('CampoNombre');
const CApellido = document.getElementById('CampoApellidos');
const CContacto = document.getElementById('CampoContacto');
const btnRes = document.getElementById('Reservar');
var tipos; 
var STipos = document.querySelectorAll('.STipo');
var SHabitaciones = document.querySelectorAll('.SHabitacion');

//Cargar documento
window.addEventListener("load", function(e){

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
        console.log(texto);
        tipos = JSON.parse(texto);
        console.log(tipos);
    })
    .catch(function(err) {
        console.log(err);
     });
});
//Crear events listeners a los SELECTS de TIPOS
//Contador de Habitaciones
var contador = 0;
//Evento de click en el botón Añadir
btnAdd.addEventListener("click", function(e){
    e.preventDefault();
    //Verifica el límite permitido de habitaciones por reservacion (5)
    if (contador<5) {
       crearLinea(contador+2)
        //Añadir al contador
        contador = contador+1;
    }

   
});

function crearLinea(numero) {
    //Declaración de elementos basicos
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
   crearOpciones(tipos, iTipo);
   //Agregar opciones habitaciones
    var habitaciones;
    const infoPTipo = new FormData();
    infoPTipo.append('Tipo', tipos[0].TipoHab_ID);
    infoPTipo.append('CIN', Check_In.value);
    infoPTipo.append('COUT', Check_Out.value);
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
        console.log(texto);
        switch (texto) {
            case "1":
                alert("Error en la verificación del hotel");
                break;
            case "0":
                alert("No hay habitaciones disponibles");
                break;
            default:
                console.log(texto);
                habitaciones = JSON.parse(texto);
                crearOpciones(habitaciones, iHabitacion);
                //Agregar elementos
                contenedor.appendChild(iTipo);
                contenedor.appendChild(iHabitacion);
                contenedor.appendChild(br);
                STipos = document.querySelectorAll('.STipo');
                SHabitaciones = document.querySelectorAll('.SHabitacion');
                iTipo.addEventListener('change', cambiarOpciones);
                validarFechas();
                break;
        }
    })
    .catch(function(err) {
        console.log(err);
     }); 


}

//Funcion que obtiene las habitaciones según el tipo
function cambiarOpciones() {
    const SelectOpciones = this.nextSibling;
    const TipoNuevo = this.value;
    console.log(TipoNuevo);
        for (let i = SelectOpciones.options.length; i >= 0; i--) {
            SelectOpciones.remove(i);
        }

    console.log(SelectOpciones);
    //AJAX
    const infoNTipo = new FormData();
    infoNTipo.append('Tipo', TipoNuevo);
    infoNTipo.append('CIN', Check_In.value);
    infoNTipo.append('COUT', Check_Out.value);
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
                validarFechas();
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
Check_In.addEventListener('change', validarFechas);
Check_Out.addEventListener('change', validarFechas);
Check_Out.addEventListener('change', borrarLineas);
Check_In.addEventListener('change', borrarLineas);
function validarFechas(){
    
    var FCheckIn = new Date(Check_In.value);
    var FCheckOut = new Date(Check_Out.value);
    FCheckIn.setHours(0,0,0,0);
    FCheckOut.setHours(0,0,0,0);
    if (FCheckOut>FCheckIn) {
        const dias = Math.abs(FCheckOut-FCheckIn)/(86400000);
        btnAdd.disabled = false;
        determinarPrecio(dias);
        revisarBoton();
        
    }else{
        if (FCheckOut!="Invalid Date" && FCheckIn!="Invalid Date") {
            alert("Error, el checkout debe ser mayor al checkin");
        }
        PTOTAL.innerText = "$0";
        btnAdd.disabled = true;
        btnRes.disabled = true;
    }
    
}

function determinarPrecio(dias) {
    var Total=0;
        STipos.forEach(TSelect => {
            tipos.forEach(TJSON => {
                if (TSelect.value==TJSON.TipoHab_ID) {
                    Total = Total + parseInt(TJSON.TipoHab_Precio);
                }
            });
        });
        console.log(Total);
        console.log(dias);
        PTOTAL.innerText = "$"+Total*dias;
}

function borrarLineas() {
    STipos.forEach(element => {
        element.remove();
    });
    SHabitaciones.forEach(element =>{
        element.remove();
    });
    contador = 0;
    var BR = contenedor.querySelectorAll('br');
    BR.forEach(element =>{
        element.remove();
    });
    PTOTAL.innerText = "$0";
}

btnRes.addEventListener('click', function (e) {
    e.preventDefault();
    const infoReserva = new FormData();
    infoReserva.append('Nombre', CNombre.value);
    infoReserva.append('Apellidos', CApellido.value);
    infoReserva.append('Contacto', CContacto.value);
    infoReserva.append('CIN', Check_In.value);
    infoReserva.append('COUT', Check_Out.value);

    fetch ('../backend/reservar.php', {
        method:'POST',
        body: infoReserva
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto){
        registrarHabitaciones(texto);
        window.location.href="https://corporativotdo.com/Recepcion/Reservacion/ConsultarReservaciones/ConsultaReservaciones.php";
    })
    .catch(function(err) {
        console.log(err);
     }); 


});

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
   
}

function reiniciarCampos() {
    Check_In.value="";
    Check_Out.value="";
    CContacto.value="";
    CApellido.value="";
    CNombre.value="";
    borrarLineas()
}

CApellido.addEventListener('keyup', revisarBoton);
CNombre.addEventListener('keyup', revisarBoton);
CContacto.addEventListener('keyup', revisarBoton);
function revisarBoton(){
    console.log(CApellido.value);
    if (CApellido.value != "" && CNombre.value != "" && CContacto.value != "" && SHabitaciones.length>0) {
        btnRes.disabled = false;
        console.log("habilitar");
    }
    else{
        btnRes.disabled = true;
        console.log("Deshabilitar");
    }
}