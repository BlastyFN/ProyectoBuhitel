//ELEMENTOS TARJETA
const textoHabitacion = document.getElementById('txtHab');
const textoServicio = document.getElementById('txtServ');
const textoHora = document.getElementById('txtHora');
const textoStatus = document.getElementById('txtEstatus');
//ELEMENTOS EXTRA
const LineasServicio = document.querySelectorAll('tbody > tr');
const btnConfirmar = document.getElementById('btnConfirmar');
const btncCancelar = document.getElementById('btnCancelar');
const infoTabla = document.getElementById('CuerpoTabla');
const Sonido = new Audio("../../../Recursos/Campana.mp3");
var ActForz =true;
var ServicioActual;
var Servicios = [];
//LA CLASE QUE SE USARÁ PARA LAS LINEAS
class Servicio { 
    constructor(ID, Habitacion, Fecha, Estatus){
        this.ID = ID;
        this.Habitacion = Habitacion;
        this.Fecha = Fecha;
        this.Estatus = Estatus;
    }
    get HTML(){
        return this.obtenerHTML();
    }

    obtenerHTML(){
     //Crea cada línea con al información obtenida del JSON
        var iFila = document.createElement('tr');
        var iServicio = document.createElement('td');
        var iHora = document.createElement('td');
        var iEstatus = document.createElement('td');
        iServicio.appendChild(document.createTextNode(this.ID));
        iHora.appendChild(document.createTextNode(this.Hora));
        iEstatus.appendChild(document.createTextNode(this.Estatus));
        iFila.appendChild(iServicio);
        iFila.appendChild(iHora);
        iFila.appendChild(iEstatus);
        //Añade el evento de cada fila para seleccionar el vehículo
        iFila.addEventListener('click', obtenerServicio);
        return iFila;
    }

    get Hora(){
        return this.ObtenerHora();
    }

    ObtenerHora(){
        let Fecha = this.Fecha;
        let partes = Fecha.split(" ");
        let Hora = partes[1].slice(0, -3);
        return Hora;
    }
}


//Cargar tabla cuando se carga la ventana
window.addEventListener('load', cargarTabla);
var intervalo = window.setInterval(cargarTabla, 10000);
function cargarTabla() {

    //CONSULTA
    fetch('../backend/consultarServicios.php', {
        method:'POST',
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        if (texto!="0") {
            let ServiciosNuevos = [];
            let jsonSERV = JSON.parse(texto);
            
            // Crea el objeto
            jsonSERV.forEach(element => {
                const SER = new Servicio(
                    element.Servicio_ID,
                    element.Habitacion_Nombre,
                    element.Servicio_Fecha,
                    element.EstatusServicio_Nombre
                );
                //Añade el objeto al array de objetos
                ServiciosNuevos.push(SER);
       
             }); 
             verificarNuevo(ServiciosNuevos);
        }
        else{
            while (infoTabla.firstChild) {
                infoTabla.removeChild(infoTabla.firstChild);
            }
        }
     })
     .catch(function(err) {
        console.log(err);
     });
}

//Obtiene el servicio seleccionado y lo consulta
function obtenerServicio() {
    var SER = this.querySelector('td').textContent;
    
    ServicioActual = Servicios.find(element => element.ID === SER);
    textoHabitacion.innerHTML = "Habitacion: " + ServicioActual.Habitacion;
    textoServicio.innerHTML = "Pedido: #" + ServicioActual.ID;
    textoHora.innerHTML = "Hora: " + ServicioActual.Hora;
    textoStatus.innerHTML = "Estatus: " + ServicioActual.Estatus;
    determinarColor(ServicioActual.Estatus);
    obtenerProductos(ServicioActual.ID);
}

function verificarNuevo(Lista) {
    console.log(Lista);
    console.log(Servicios);
    if (ActForz == true) {
        ActForz = false;
        Servicios = Lista;
        desplegadora(Servicios);
    }
    if (Lista.length != Servicios.length) {
        Servicios = Lista;
        desplegadora(Servicios);
    }
    else{
        var Desplegar = false;
        Lista.forEach(ServicioN => {
            NuevoID = ServicioN.ID;
            if (Servicios.some(e => e.ID === NuevoID)) {
            }
            else{
                Desplegar = true;  
            }
        });
        if (Desplegar == true) {
            Servicios = Lista;
            desplegadora(Servicios);
        }
    }
}

function desplegadora(Lista) {
    Sonido.play();
    //Elimina los elementos de la tabla
    while (infoTabla.firstChild) {
        infoTabla.removeChild(infoTabla.firstChild);
    }
    Lista.forEach(element => {
        infoTabla.appendChild(element.HTML);
    });
}

function determinarColor(Estatus) {
    let ColorViejo;
    let ColorNuevo;
    let Valor;
    let btnTexto;
    switch (Estatus) {
        case "Pendiente":
            ColorViejo = "Verde";
            ColorNuevo = "Naranja";
            Valor = 2;
            btnTexto = "Comenzar";
        break;
        case "En Curso":
            ColorNuevo = "Verde";
            ColorViejo = "Naranja";
            Valor = 3;
            btnTexto = "Completar";
        break;
        default:
            ColorViejo = "Verde";
            ColorNuevo = "Naranja";
            Valor = 1;
            btnTexto ="Pendiente";
        break;
    }
    textoServicio.classList.remove(ColorViejo);
    textoHora.classList.remove(ColorViejo);
    textoStatus.classList.remove(ColorViejo);
    btnConfirmar.classList.remove(ColorViejo);
    textoServicio.classList.add(ColorNuevo);
    textoHora.classList.add(ColorNuevo);
    textoStatus.classList.add(ColorNuevo);
    btnConfirmar.classList.add(ColorNuevo);
    btnConfirmar.setAttribute('value', Valor);
    btnConfirmar.innerHTML = btnTexto;
}

btnConfirmar.addEventListener('click', function () {
    
    const infoActualizar = new FormData();
    infoActualizar.append('Estatus', this.value);
    infoActualizar.append('Servicio', ServicioActual.ID);
    fetch('../backend/actualizarEstatus.php', {
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
    .then(function(texto) {
        alert(texto); 
        ActForz = true;
        cargarTabla();
        if (this.value = "2") {
            determinarColor("En Curso");
        }
     })
     .catch(function(err) {
        console.log(err);
     }); 
});

btncCancelar.addEventListener('click', function () {
    const infoEliminar = new FormData();
    infoEliminar.append('Servicio', ServicioActual.ID);
    fetch('../backend/cancelarServicio.php', {
        method:'POST',
        body: infoEliminar
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
        // ActForz = true;
        // cargarTabla();
        window.location.reload();
     })
     .catch(function(err) {
        console.log(err);
     }); 
})

function obtenerProductos(SERID) {
    const infoCarritos = new FormData();
    infoCarritos.append('Servicio', SERID);
    fetch('../backend/consultarCarritos.php', {
        method:'POST',
        body: infoCarritos
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        if (texto != "0" && texto != "x") {
            const ContenedorProductos = document.getElementById('SeccionCarritos');
            while (ContenedorProductos.firstChild) {
                ContenedorProductos.removeChild(ContenedorProductos.firstChild);
            }
            let Carritos = JSON.parse(texto);
            // console.log(Carritos);
            Carritos.forEach(Carrito => {
                let LineaProducto = document.createElement('h1');
                LineaProducto.classList.add("Morado");
                LineaProducto.classList.add("TextoCompleto");
                LineaProducto.classList.add("RedMid");
                LineaProducto.innerHTML = "#" + Carrito.CarroProd_NumProductos + "  " + Carrito.Producto_Nombre;
                ContenedorProductos.appendChild(LineaProducto);
            });
        }
        else{
            console.log(texto);

        }
     })
     .catch(function(err) {
        console.log(err);
     }); 
}