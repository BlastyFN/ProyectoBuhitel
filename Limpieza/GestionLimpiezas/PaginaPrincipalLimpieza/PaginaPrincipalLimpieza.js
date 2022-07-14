const Tabla = document.getElementById("CuerpoTabla");
const btnCompletar = document.getElementById("btnConfirmar");
const txtNotas = document.getElementById("txtNotas");
const txtHabitacion = document.getElementById("txtHab");
const txtPiso = document.getElementById("txtPiso");
const txtHora = document.getElementById("txtHora");
const txtTipo = document.getElementById("txtTipo");
var NLimpID;
class Limpieza { 
    constructor(ID, Habitacion, Inicio, Fin, Estatus, Tipo, Piso){
        this.ID = ID;
        this.Habitacion = Habitacion;
        this.Inicio = Inicio;
        this.Fin = Fin;
        this.Estatus = Estatus;
        this.Tipo = Tipo;  
        this.Piso = Piso; 
    }
    get HTML(){
        return this.obtenerHTML();
    }

    get NumFecha(){
        return this.obtenerNumFecha();
    }
    obtenerHTML(){
     //Crea cada línea con al información obtenida del JSON
        var iFila = document.createElement('tr');
        var iHabitacion = document.createElement('td');
        var iInicio = document.createElement('td');
        var IFinal = document.createElement('td');
        var iTipo = document.createElement('td');
        iHabitacion.appendChild(document.createTextNode(this.Habitacion));
        iInicio.appendChild(document.createTextNode(this.obtenerHora(this.Inicio)));
        IFinal.appendChild(document.createTextNode(this.obtenerHora(this.Fin)));
        iTipo.appendChild(document.createTextNode(this.Tipo));
        iFila.appendChild(iHabitacion);
        iFila.appendChild(iInicio);
        iFila.appendChild(IFinal);
        iFila.appendChild(iTipo);
        return iFila;
    }

    obtenerHora(Fecha) {
        var PartesFecha = Fecha.split(" ");
        var Hora = PartesFecha[1];
        var HoraFinal = Hora.slice(0, 5);
        return HoraFinal;
    }

    obtenerNumFecha(){

        let FormFecha = new Date(this.Inicio);
        return FormFecha.getTime();
    }
}

window.addEventListener('load', cargarTabla);
var intervalo = window.setInterval(cargarTabla, 30000);
function cargarTabla() {
    //CONSULTA
    fetch('../backend/ObtenerLimpiezasDeHoy.php', {
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
            var LimpiezasNuevas = [];
            let jsonLimps = JSON.parse(texto);
            
            // Crea el objeto
            jsonLimps.forEach(element => {
                const LIMP = new Limpieza(
                    element.Limpieza_ID,
                    element.Habitacion_Nombre,
                    element.Limpieza_HoraInicio,
                    element.Limpieza_HoraFin,
                    element.EstatusLimpieza_Nombre,
                    element.Limpieza_Tipo,
                    element.Piso_Numero
                );
                //Añade el objeto al array de objetos
                LimpiezasNuevas.push(LIMP);
                
             }); 
             desplegadora(LimpiezasNuevas);
        }
        else{
        }
     })
     .catch(function(err) {
        console.log(err);
     });
}

function desplegadora(Limpiezas) {
    while (Tabla.firstChild) {
        Tabla.removeChild(Tabla.firstChild);
    }
    Limpiezas.sort(((a, b) => a.NumFecha - b.NumFecha));
    Limpiezas.forEach(Limpieza => {
        Tabla.appendChild(Limpieza.HTML);
    });
    determinarNueva(Limpiezas[0]);
}


function determinarNueva(Limp) {
    console.log(Limp.Habitacion);
    txtHabitacion.innerHTML = "Habitacion "+ Limp.Habitacion;
    txtPiso.innerHTML = "Piso: #"+ Limp.Piso;
    txtTipo.innerHTML = "Tipo: "+ Limp.Tipo;
    var Fecha = Limp.Inicio;
    var PartesFecha = Fecha.split(" ");
    var Hora = PartesFecha[1];
    var TextoHora = Hora.slice(0, 5);
    txtHora.innerHTML = "Hora: "+TextoHora;
    NLimpID = Limp.ID;
}

btnCompletar.addEventListener("click", function () {
    //EN LA BD 1 = Pendiente, 2 = En proceso y 3 = Completada
    switch (this.value) {
        case '1':
            alert("En proceso");
            this.value = 2;
            this.innerHTML = "En proceso";
            cambiarEstatus(2);
            //
            break;
        case '2':
            alert("Completado");
            this.value = 1;
            this.innerHTML = "Completado";
            cambiarEstatus(3);
            window.location.reload()

            break;
    
        default:
            break;
    }
});

function cambiarEstatus(Estatus) {
        //CONSULTA
    const infoLimpieza = new FormData();
    infoLimpieza.append("Notas", txtNotas.value);
    infoLimpieza.append("Limpieza", NLimpID);
    infoLimpieza.append("Estatus", Estatus);
    fetch('../backend/cambiarEstatusLimpieza.php', {
        method:'POST',
        body: infoLimpieza
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
       if (texto == '1') {
        console.log("Exito");
       }
       else{
        alert("Error");
        console.log(texto);
       }
     })
     .catch(function(err) {
        console.log(err);
     });
}