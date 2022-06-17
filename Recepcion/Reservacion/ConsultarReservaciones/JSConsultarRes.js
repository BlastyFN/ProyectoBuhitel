const contenedorPrincipal = document.getElementById('ContenedorM');
const btnVerde = document.getElementById('BtnIzq');
const btnRojo = document.getElementById('BtnMid');
const btnMorado = document.getElementById('BtnDer');
const btnGris = document.getElementById('BtnG');
const btnBuscar = document.getElementById('BtnBuscar');
const campoHuesped = document.getElementById('campoHuesped');
const campoHabitacion = document.getElementById('campoHabitacion');
var VRMG = [true, true, true, false];
var Reservaciones = [];
class TarjetaReservacion{
    constructor(ID, CheckIn, CheckOut, Nombre, Apellidos, Habitacion, Contacto, Codigo, TipoHab, Reservacion){
        this.ID = ID;
        this.CheckIn = CheckIn;
        this.CheckOut = CheckOut;
        this.Nombre = Nombre;
        this.Apellidos = Apellidos;
        this.Habitacion = Habitacion;
        this.Contacto = Contacto;
        this.Codigo = Codigo;
        this.TipoHab = TipoHab;
        this.Reservacion = Reservacion;
    }
    get HTML(){
        return this.obtenerHTML();
    }
    get Tipo(){
        return this.obtenerTipo();
    }
    get NombreCompleto(){
        return this.obtenerNombreCompleto();
    }
    obtenerHTML(){
        var iTarjeta = document.createElement('div');
        var iHabitacion = document.createElement('h1');
        var iContInfo = document.createElement('div');
        var iNombre = document.createElement('p');
        var iApellidos = document.createElement('p');
        var iContacto = document.createElement('p');
        var iCodigo = document.createElement('p');
        var iCheckIn = document.createElement('p');
        var iCheckOut = document.createElement('p');
        //BOTONES
        var iContBtn = document.createElement('div');
        var iEditar = document.createElement('button');
        //Añadir clases
        //TARJETA
        iTarjeta.classList.add('Tarjeta');
        iTarjeta.classList.add(this.Tipo);
        //HABITACION
        iHabitacion.classList.add('Info');
        //CONTENEDOR INFORMACION
        iContInfo.classList.add('Info');
        //AÑADIR TEXTO A LA INFORMACIÓN
        iHabitacion.appendChild(this.crearNodoTexto(this.Habitacion));
        iNombre.appendChild(this.crearNodoTexto(this.Nombre));
        iApellidos.appendChild(this.crearNodoTexto(this.Apellidos));
        iContacto.appendChild(this.crearNodoTexto(this.Contacto));
        iCodigo.appendChild(this.crearNodoTexto(this.Codigo));
        iCheckIn.appendChild(this.crearNodoTexto(this.CheckIn));
        iCheckOut.appendChild(this.crearNodoTexto(this.CheckOut));
        //AÑADIR INFORMACIÓN AL CONTENEDOR
        iContInfo.appendChild(iNombre);
        iContInfo.appendChild(iApellidos);
        iContInfo.appendChild(iContacto);
        iContInfo.appendChild(iCodigo);
        iContInfo.appendChild(iCheckIn);
        iContInfo.appendChild(iCheckOut);
        //AÑADIR INFO A BOTON EDITAR
        iEditar.classList.add('Naranja');
        iEditar.appendChild(this.crearNodoTexto("Editar"));
        iEditar.setAttribute('value', this.Reservacion);
        iEditar.addEventListener('click', editar);
        if (this.Tipo == "Verde" || this.Tipo == "Gris") {
            var iCancelar = document.createElement('button');
                iCancelar.appendChild(this.crearNodoTexto("Cancelar"));
                iCancelar.classList.add('Naranja');
                iCancelar.classList.add('Ult');
                iCancelar.setAttribute('id', this.ID);
                iContBtn.appendChild(iEditar);
                iContBtn.appendChild(iCancelar);

                iCancelar.addEventListener('click', callbackCanc);
        }
        else{
            if (this.Tipo == "Rojo" || this.Tipo == "Morado") {
                iEditar.classList.add('Ult');
                iContBtn.appendChild(iEditar);
            }
        }
      
        
        //AÑADIR TOTALES
        iTarjeta.appendChild(iHabitacion);
        iTarjeta.appendChild(iContInfo);
        iTarjeta.appendChild(iContBtn);
        return iTarjeta;
    }
    crearNodoTexto(Texto){
        var Nodo = document.createTextNode(Texto);
        return Nodo;
    }
    obtenerTipo(){
        var FCIN = new Date(this.CheckIn); 
        var FCOUT = new Date(this.CheckOut); 
        var Hoy = new Date();
        Hoy.setHours(0,0,0,0);
        var Mañana = new Date(Hoy.getTime()+86400000);
        var Tipo;
        var H = Hoy.getTime();
        var M = Mañana.getTime();
        var I = FCIN.getTime();
        var O = FCOUT.getTime();
        if (H<I && I<M) {
            Tipo ="Verde";
        }
        else{
            if (H<O &&O<M) {
                Tipo = "Rojo";
            }
            else{
                if (I<H && O>M) {
                    Tipo = "Morado";
                }
                else{
                    Tipo ="Gris";
                }
            }
        }
        return Tipo;
    }

    obtenerNombreCompleto(){
        return this.Nombre + " " +this.Apellidos;
    }


}

window.addEventListener('load', obtenerHabRes);
function obtenerHabRes() {
    fetch('../backend/consultaHabRes.php', {
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
        switch (texto) {
            case '1':
                console.log("Problemas de autenticación")
                break;
            case '0':
                alert("No hay nada que mostrar")
                break;
        
            default:
                var habRes;
                habRes = JSON.parse(texto);
                console.log(habRes); 
                habRes.forEach(element => {
                    const TR = new TarjetaReservacion(
                        element.HabReservada_ID,
                        element.Reservacion_CheckIn,
                        element.Reservacion_CheckOut,
                        element.Huesped_Nombre,
                        element.Huesped_Apellidos,
                        element.Habitacion_Nombre,
                        element.Huesped_Contacto,
                        element.HabReservada_CodigoWhatsapp,
                        element.TipoHab_Nombre,
                        element.Reservacion_ID
                    );
                    Reservaciones.push(TR);
                }); 
                console.log(Reservaciones);
                
                for (let index = 0; index < 3; index++) {
                    VRMG[index] = true;
                    
                }
                VRMG[3] = false;
                separadora(VRMG);
                break;
        }
    })
    .catch(function(err) {
        console.log(err);
     });
}

btnVerde.addEventListener('click', function(e) {
   e.preventDefault(); 
   alternarColor(0, this, "Verde", "GrisV");

});

btnRojo.addEventListener('click', function(e) {
    e.preventDefault(); 
    alternarColor(1, this, "Rojo", "GrisR");
 });

 btnMorado.addEventListener('click', function(e) {
    e.preventDefault(); 
    alternarColor(2, this, "Morado", "GrisM");
 });

 btnGris.addEventListener('click', function (e) {
    e.preventDefault();
    alternarColor(3, this, "Gris", "GrisG");
 });
function alternarColor(Posicion, Boton, Color, Gris) {
    campoHabitacion.value="";
    campoHuesped.value="";
    if (VRMG[Posicion] == true) {
        Boton.classList.replace(Color, Gris);
        VRMG[Posicion] = false;
    }
    else{
        Boton.classList.replace(Gris, Color);
        VRMG[Posicion] = true;
    }
    console.log(Color+" = "+VRMG[Posicion]);
    separadora(VRMG);
}

function separadora(Colores) {
    // var desplegables = Reservaciones;
    var Verdes=[];
    var Rojas=[];
    var Moradas=[];
    var Grises=[];
   if (Colores[0] == true) {
        Verdes = Reservaciones.filter(function (Habitacion) {
            return Habitacion.Tipo === "Verde";
        });
   }
   else{

   }
    if (Colores[1] == true) {
        Rojas = Reservaciones.filter(function (Habitacion) {
            return Habitacion.Tipo === "Rojo";
        }); 
    }
    if (Colores[2] == true) {
        Moradas = Reservaciones.filter(function (Habitacion) {
            return Habitacion.Tipo === "Morado";
        }); 
    }
    if (Colores[3] == true) {
        Grises = Reservaciones.filter(function (Habitacion) {
            return Habitacion.Tipo === "Gris";
        });
    }
    
    
    var desplegables = Verdes.concat(Rojas, Moradas, Grises);

    console.log(Grises);
    desplegadora(desplegables);
}

function desplegadora(tarjetas) {
    contador = 4;
    while (contenedorPrincipal.firstChild) {
        contenedorPrincipal.removeChild(contenedorPrincipal.firstChild);
    }
    tarjetas.forEach(element => {
        if (contador==4) {

            Fila = crearFila();
            contenedorPrincipal.appendChild(Fila);
            contador = 0;
            var BR1 = document.createElement('br');
            var BR2 = document.createElement('br');
            contenedorPrincipal.appendChild(BR1);
            contenedorPrincipal.appendChild(BR2);
        }
        // console.log(element.HTML);
        contador = contador+1;
        Fila.appendChild(element.HTML);
    });
}
var contadorFilas=0;
function crearFila() {
    var iFila = document.createElement('section');
    iFila.classList.add('contenedor');
    iFila.classList.add('centrarItems');
    iFila.setAttribute('id', ""+contadorFilas);
    contadorFilas=contadorFilas+1;
    
    return iFila;
}

btnBuscar.addEventListener('click', function (e) {
    e.preventDefault();

    
    var desplegables = [];
    if (campoHuesped.value != "" && campoHabitacion.value!="") {
        console.log();
        desplegables = Reservaciones.filter(function (Reservacion) {
           return Reservacion.Nombre === campoHuesped.value && Reservacion.Habitacion == campoHabitacion.value || Reservacion.Apellidos === campoHuesped.value && Reservacion.Habitacion == campoHabitacion.value || Reservacion.NombreCompleto === campoHuesped.value && Reservacion.Habitacion == campoHabitacion.value || Reservacion.Nombre === campoHuesped.value && Reservacion.TipoHab == campoHabitacion.value || Reservacion.Apellidos === campoHuesped.value && Reservacion.TipoHab == campoHabitacion.value || Reservacion.NombreCompleto === campoHuesped.value && Reservacion.TipoHab == campoHabitacion.value; 
        });
    }else{
        if (campoHuesped.value!="") {
            desplegables = Reservaciones.filter(function (Reservacion) {
                return Reservacion.Nombre === campoHuesped.value || Reservacion.Apellidos === campoHuesped.value || Reservacion.NombreCompleto === campoHuesped.value;
            })
        } else {
            if (campoHabitacion.value!="") {
                desplegables = Reservaciones.filter(function (Reservacion) {
                    return Reservacion.Habitacion === campoHabitacion.value || Reservacion.TipoHab === campoHabitacion.value;
                })
            }
        }
    }
    
    
    desplegadora(desplegables);
});

function callbackCanc() {
    const infoReservacion = new FormData();
        infoReservacion.append('HabRes', this.id);
        fetch ('../backend/cancelarHabRes.php', {
            method:'POST',
            body: infoReservacion
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
                    alert("Cancleada con éxito");
                    Reservaciones = [];
                    obtenerHabRes();
                    break;
                case "0":
                    alert("Problema de cancelacion");
                    break;
                default:
                    alert(texto);
                    break;
            }
        })
        .catch(function(err) {
            console.log(err);
         }); 
}

function editar() {
    
    localStorage.setItem("Editar", this.value);    
    window.location.href="https://corporativotdo.com/Recepcion/Reservacion/EditarReservacion/EdicionReservacion.php";
}