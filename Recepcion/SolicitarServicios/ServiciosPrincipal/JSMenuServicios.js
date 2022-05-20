const contenedorLimpiezas = document.getElementById('ContenedorL');
const contenedorServicios = document.getElementById('ContenedorS');
const botonBuscar = document.getElementById('btnBuscar');
const barraHabitacion = document.getElementById('tituloHab');
const campoHabitacion = document.getElementById('cmpHabitacion');
var IDHabitacion;
class TarjetaLimpieza {
    constructor(habitacion, color, nombre, apellidos, inicio, fin, id){
        this.habitacion = habitacion;
        this.color = color;
        this.nombre = nombre;
        this.apellidos = apellidos;
        this.inicio = inicio;
        this.fin = fin;
        this.id = id;
    }
    get HTML() {
        return this.obtenerHTML();
    }
    obtenerHTML(){
       //NODOS DE TEXTO
       var NodoTitulo = document.createTextNode(this.habitacion);
       var NodoNombre = document.createTextNode(this.nombre);
       var NodoApellidos = document.createTextNode(this.apellidos);
       var NodoInicio = document.createTextNode(this.inicio);
       var NodoFin = document.createTextNode(this.fin);
       var NodoBotonCancelar = document.createTextNode("Cancelar");
       var NodoBotonEditar = document.createTextNode("Editar");
        //Div general
        var iTarjeta = document.createElement('div');
        iTarjeta.classList.add('TarjetaMul');
        iTarjeta.classList.add(this.color);
        iTarjeta.setAttribute("id", "TarLimpieza");
        //Titulo Tarjeta
        var iTitulo = document.createElement('h1');
        iTitulo.classList.add('Info');
        iTitulo.appendChild(NodoTitulo);
        //Div info
        var iInformacion = document.createElement('div');
        iInformacion.classList.add('Info');
        //INFORMACIÓN
        var iNombre = document.createElement('p');
        iNombre.appendChild(NodoNombre);
        var iApellidos = document.createElement('p');
        iApellidos.appendChild(NodoApellidos);
        var iInicio = document.createElement('p');
        iInicio.appendChild(NodoInicio);
        var iFin = document.createElement('p');
        iFin.appendChild(NodoFin);
        
        iInformacion.appendChild(iNombre);
        iInformacion.appendChild(iApellidos);
        iInformacion.appendChild(iInicio);
        iInformacion.appendChild(iFin);
        //BOTON EDITAR
        var iBotonEditar = document.createElement('button');
        iBotonEditar.classList.add('Naranja');
        // iBotonEditar.classList.add('ModelBtn');
        iBotonEditar.appendChild(NodoBotonEditar);
        iBotonEditar.setAttribute('value', this.id);
        iBotonEditar.setAttribute('name', this.inicio);
        iBotonEditar.setAttribute('id', this.habitacion);
        iBotonEditar.addEventListener('click', editarLimp);
        //BOTON CANCELAR 
        var iBotonCancelar = document.createElement('button');
        iBotonCancelar.classList.add('Naranja');
        iBotonCancelar.classList.add('ModelBtn');
        iBotonCancelar.classList.add('Ult');
        iBotonCancelar.appendChild(NodoBotonCancelar);
        iBotonCancelar.setAttribute('value', this.id);
        iBotonCancelar.addEventListener('click', interCancelarS);
        //Integrar todo en tarjeta
        iTarjeta.appendChild(iTitulo);
        iTarjeta.appendChild(iInformacion);
        iTarjeta.appendChild(iBotonEditar);
        iTarjeta.appendChild(iBotonCancelar);
        return iTarjeta;
    }
}

class TarjetaServicios {
    constructor(habitacion, color, nombre, apellidos, fecha, precio, estatus, id){
        this.habitacion = habitacion;
        this.color = color;
        this.nombre = nombre;
        this.apellidos = apellidos;
        this.fecha = fecha;
        this.precio = precio;
        this.estatus = estatus;
        this.id = id;
    }
    get HTML() {
        return this.obtenerHTML();
    }
    obtenerHTML(){
       //NODOS DE TEXTO
       var NodoTitulo = document.createTextNode(this.habitacion);
       var NodoNombre = document.createTextNode(this.nombre);
       var NodoApellidos = document.createTextNode(this.apellidos);
       var NodoFecha = document.createTextNode(this.fecha);
       var NodoPrecio = document.createTextNode("$"+this.precio);
       var NodoEstatus = document.createElement(this.estatus);
       var NodoBotonCancelar = document.createTextNode("Cancelar");
       var NodoBotonEditar = document.createTextNode("Editar");
        //Div general
        var iTarjeta = document.createElement('div');
        iTarjeta.classList.add('TarjetaMul');
        iTarjeta.classList.add(this.color);
        iTarjeta.setAttribute("id", "TarLimpieza");
        //Titulo Tarjeta
        var iTitulo = document.createElement('h1');
        iTitulo.classList.add('Info');
        iTitulo.appendChild(NodoTitulo);
        //Div info
        var iInformacion = document.createElement('div');
        iInformacion.classList.add('Info');
        //INFORMACIÓN
        var iNombre = document.createElement('p');
        iNombre.appendChild(NodoNombre);
        var iApellidos = document.createElement('p');
        iApellidos.appendChild(NodoApellidos);
        var iFecha = document.createElement('p');
        iFecha.appendChild(NodoFecha);
        var iPrecio = document.createElement('p');
        iPrecio.appendChild(NodoPrecio);
        var iEstatus = document.createElement('p');
        iEstatus.appendChild(NodoEstatus);
        
        iInformacion.appendChild(iNombre);
        iInformacion.appendChild(iApellidos);
        iInformacion.appendChild(iFecha);
        iInformacion.appendChild(iPrecio);
        iInformacion.appendChild(iEstatus);
        //BOTON EDITAR
        var iBotonEditar = document.createElement('button');
        iBotonEditar.classList.add('Naranja');
        // iBotonEditar.classList.add('ModelBtn');
        iBotonEditar.appendChild(NodoBotonEditar);
        iBotonEditar.setAttribute('value', this.id);
        iBotonEditar.setAttribute('id', this.habitacion);
        iBotonEditar.addEventListener('click', editarServ);
        //BOTON CANCELAR 
        var iBotonCancelar = document.createElement('button');
        iBotonCancelar.classList.add('Naranja');
        iBotonCancelar.classList.add('ModelBtn');
        iBotonCancelar.classList.add('Ult');
        iBotonCancelar.appendChild(NodoBotonCancelar);
        iBotonCancelar.setAttribute('value', this.id);
        iBotonCancelar.addEventListener('click', interCancelarSer);
        //Integrar todo en tarjeta
        iTarjeta.appendChild(iTitulo);
        iTarjeta.appendChild(iInformacion);
        iTarjeta.appendChild(iBotonEditar);
        iTarjeta.appendChild(iBotonCancelar);
        return iTarjeta;
    }
}

campoHabitacion.addEventListener('keyup', function() {
    if (this.value != "") {
        botonBuscar.disabled = false;
    }
    else{
        botonBuscar.disabled = true;
    }

});

botonBuscar.addEventListener('click', function () {
    const infoHabitacion = new FormData();
    infoHabitacion.append('Habitacion', campoHabitacion.value);
    fetch('../backend/consultarOcupacion.php', {
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
    .then(function(texto) {
        if (texto != "x" && texto !="0") {
            
            var informacion = JSON.parse(texto);
            var HabID = informacion.Habitacion_ID;
            IDHabitacion = HabID;
            console.log(informacion);
            determinarTitulo("Verde", "Habitacion "+informacion.Habitacion_Nombre);
            consultarLimpiezas(HabID);
            consultarServicios(HabID);
        }
        else{
            if (texto =="x") {
                alert("Error");
            }
            else{
                if (texto == "0") {
                    determinarTitulo("Rojo", "Habitacion no disponible");
                }
            }
        }
     })
     .catch(function(err) {
        console.log(err);
     }); 
});

function determinarTitulo(Color, Texto) {
    barraHabitacion.classList.remove("Azul");
    barraHabitacion.classList.remove("Rojo");
    barraHabitacion.classList.remove("Verde");
    barraHabitacion.classList.add(Color);
    barraHabitacion.innerHTML = Texto;
}

function consultarLimpiezas(Habitacion) {
    const infoHabitacion = new FormData();
    infoHabitacion.append('Habitacion', Habitacion);
    fetch('../backend/consultarLimpiezas.php', {
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
    .then(function(texto) {
        if (texto!="0" && texto!="x") {
            var ListaLimpiezas = JSON.parse(texto);
            console.log(ListaLimpiezas);
            var TarjetasLimpiezas = [];
            ListaLimpiezas.forEach(element => {
                var LimpTar = new TarjetaLimpieza(element.Habitacion_Nombre, "Azul", element.Personal_Nombre, element.Personal_APaterno+" "+element.Personal_AMaterno, element.Limpieza_HoraInicio, element.Limpieza_HoraFin, element.Limpieza_ID);
                console.log(LimpTar.HTML);
                TarjetasLimpiezas.push(LimpTar);
            });
            
            console.log(TarjetasLimpiezas);
            desplegadora(contenedorLimpiezas, TarjetasLimpiezas, "Limpiezas:");
        }
        else{
            alert("No se encontraron limpiezas");
            while (contenedorLimpiezas.firstChild) {
                contenedorLimpiezas.removeChild(contenedorLimpiezas.firstChild);
            }
        }
     })
     .catch(function(err) {
        console.log(err);
     }); 
}



function desplegadora(contenedor, tarjetas, texto) {
    
    contador = 4;
    while (contenedor.firstChild) {
        contenedor.removeChild(contenedor.firstChild);
    }
    var Titular = document.createElement('h1');
    var BRS = document.createElement('br');
    Titular.innerHTML = texto;
    console.log(Titular);
    contenedor.appendChild(Titular);
    contenedor.appendChild(BRS);
    tarjetas.forEach(element => {
        if (contador==4) {

            Fila = crearFila();
            contenedor.appendChild(Fila);
            contador = 0;
            var BR1 = document.createElement('br');
            var BR2 = document.createElement('br');
            contenedor.appendChild(BR1);
            contenedor.appendChild(BR2);
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

function interCancelarS() {
    CancelarLimp(this.value);
}

function CancelarLimp(Hab) {
    const infoCancelar = new FormData();
    infoCancelar.append('Limpieza', Hab);
    fetch('../backend/cancelarLimpieza.php', {
        method:'POST',
        body: infoCancelar
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        alert(texto);
     })
     .catch(function(err) {
        console.log(err);
     });
    consultarLimpiezas(IDHabitacion);
}


function editarLimp() {
    CancelarLimp(this.value);
    localStorage.setItem("EditarLimpieza", true);
    var LimpFormato = this.name.replace(" ", "T");
    localStorage.setItem("LimpHabitacion", this.id);    
    localStorage.setItem("LimpInicio", LimpFormato);
    window.location.href="https://localhost/Buhitel/Recepcion/SolicitarServicios/SolicitarLimpieza/SolLimpieza.php";

}


function consultarServicios(Habitacion) {
    const infoHabitacionS = new FormData();
    infoHabitacionS.append('Habitacion', Habitacion);
    fetch('../backend/consultarServicios.php', {
        method:'POST',
        body: infoHabitacionS
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        if (texto!="0" && texto!="x") {
            var ListaServicios = JSON.parse(texto);
            console.log(ListaServicios);
            var TarjetasServicios = [];
            ListaServicios.forEach(element => {
                var LimpSer = new TarjetaServicios(element.Habitacion_Nombre, "Azul", element.Huesped_Nombre, element.Huesped_Apellidos, element.Servicio_Fecha, element.Servicio_PrecioTotal, element.EstatusServicio_Nombre, element.Servicio_ID);
                console.log(LimpSer.HTML);
                TarjetasServicios.push(LimpSer);
            });
            console.log(TarjetasServicios);
            var Titular = document.createElement('h1');
            var BRS = document.createElement('br');
            Titular.innerHTML = "Servicios";
            contenedorServicios.appendChild(Titular);
            contenedorServicios.appendChild(BRS);
            desplegadora(contenedorServicios, TarjetasServicios, "Servicios:");
        }
        else{
            console.log(texto);
            alert("No se encontraron Servicios");
            while (contenedorServicios.firstChild) {
                contenedorServicios.removeChild(contenedorServicios.firstChild);
            }
        }
     })
     .catch(function(err) {
        console.log(err);
     }); 
}

function interCancelarSer(){
    CancelarSer(this.value);
}

function CancelarSer(Hab) {
    const infoCancelar = new FormData();
    infoCancelar.append('Servicio', Hab);
    fetch('../backend/cancelarServicio.php', {
        method:'POST',
        body: infoCancelar
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        alert(texto);
     })
     .catch(function(err) {
        console.log(err);
     });
     consultarServicios(IDHabitacion);
}

function editarServ() {
    localStorage.setItem("EditarServicio", "true");  
    localStorage.setItem("NombreHabEd", this.id);    
    localStorage.setItem("IDServEd", this.value);
    window.location.href="https://localhost/Buhitel/Recepcion/SolicitarServicios/EditarServicio/EdServHab.php";
}