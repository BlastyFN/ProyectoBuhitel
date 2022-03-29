const contenedorPrincipal = document.getElementById('ContenedorM');
const btnVerde = document.getElementById('BtnIzq');
const btnRojo = document.getElementById('BtnMid');
const btnMorado = document.getElementById('BtnDer');
const btnBuscar = document.getElementById('BtnBuscar');
var Reservaciones = [];
class TarjetaReservacion{
    constructor(CheckIn, CheckOut, Nombre, Apellidos, Habitacion, Contacto, Codigo){
        this.CheckIn = CheckIn;
        this.CheckOut = CheckOut;
        this.Nombre = Nombre;
        this.Apellidos = Apellidos;
        this.Habitacion = Habitacion;
        this.Contacto = Contacto;
        this.Codigo = Codigo;
    }
    get HTML(){
        return this.obtenerHTML();
    }
    get Tipo(){
        return "Morado";
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
        //AÑADIR CLASES A BOTONES
        iEditar.classList.add('Naranja');
        iEditar.classList.add('Ult');
        //AÑADIR TEXTOS A BOTONES
        iEditar.appendChild(this.crearNodoTexto("Editar"));
        //AÑADIR BOTONES AL CONTENEDOR
        iContBtn.appendChild(iEditar);
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
                        element.Reservacion_CheckIn,
                        element.Reservacion_CheckOut,
                        element.Huesped_Nombre,
                        element.Huesped_Apellidos,
                        element.Habitacion_Nombre,
                        element.Huesped_Contacto,
                        element.HabReservada_CodigoWhatsapp
                    );
                    Reservaciones.push(TR);
                }); 
                console.log(Reservaciones);
                separadora();
                break;
        }
    })
    .catch(function(err) {
        console.log(err);
     });
}

function separadora() {
    var desplegables = Reservaciones;
    desplegadora(desplegables);
}

function desplegadora(tarjetas) {
    contador = 4;

    console.log(contador);
    
    tarjetas.forEach(element => {
        if (contador==4) {
            console.log(contador);
            Fila = crearFila();
            contenedorPrincipal.appendChild(Fila);
            contador = 0;
            var BR1 = document.createElement('br');
            var BR2 = document.createElement('br');
            contenedorPrincipal.appendChild(BR1);
            contenedorPrincipal.appendChild(BR2);
        }
        console.log(element.HTML);
        contador = contador+1;
        console.log(contador);
        Fila.appendChild(element.HTML);
    });
    console.log(Fila);
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