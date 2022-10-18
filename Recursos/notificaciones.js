var hotel;
const Sonido = new Audio("/Recursos/Campana.mp3");
var ReportesAlmacenados = [];
var tiemposAlmacenados = [];
var intervalo = window.setInterval(consultarReportes, 15000);
const minuto = 60000;
class Reporte{
    constructor(ID, Fecha){
        this.ID = ID;
        this.Fecha = Fecha;
    }
    get FechaNum(){
        return this.obtenerFechaNum();
    }
    obtenerFechaNum() {
        return Date.parse(this.Fecha);
    }
}

function consultarReportes() {
    //CONSULTA
    fetch('../../../General/SolucionDeReportes/BackendReportes/consultarAsignados.php', {
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
        let ReportesConsultados = [];
        let info = JSON.parse(texto);
        info.forEach(rep => {
            const NReporte = new Reporte(rep.Reporte_ID, rep.Reporte_Inicio);
            ReportesConsultados.push(NReporte);
            
        });
        // console.log(ReportesConsultados);
        compararListas(ReportesConsultados);
        consultarTiempos();
     })
     .catch(function(err) {
        console.log(err);
     });
}

function compararListas(listaNueva) {
    if (ReportesAlmacenados.length > 0 ) {
        //VERIFICAR SI HAY REPORTES QUE BORRAR
        ReportesAlmacenados.forEach(REP => {
            if (listaNueva.some(e => e.ID === REP)) {

            }
            else{
                var indice = ReportesAlmacenados.indexOf(REP);
                console.log("El reporte " + REP  + " con fecha" + tiemposAlmacenados[indice] + " ya fue leído");
                if (indice == ReportesAlmacenados.length) {
                    ReportesAlmacenados.pop();
                    tiemposAlmacenados.pop();
                }
                else{
                    if (indice == 0) {
                        ReportesAlmacenados.shift();
                        tiemposAlmacenados.shift();
                    }
                    else{
                        ReportesAlmacenados.splice(indice, 1);
                        tiemposAlmacenados.splice(indice, 1);
                    }
                }
                actualizarListas();
                //BORRAR REPORTE
            }
        });

        //VERIFICAR SI HAY REPORTES POR AÑADIR
        listaNueva.forEach(REPN => {
            if (ReportesAlmacenados.some(e => e === REPN.ID)) {

            }
            else{
                console.log("El reporte " + REPN.ID + "con fecha " + REPN.Fecha + " fue agregado");
                ReportesAlmacenados.push(REPN.ID);
                tiemposAlmacenados.push(REPN.FechaNum);
                actualizarListas();
                //AGREGAR REPORTE
            }
        });
    }
    else{
        if (listaNueva.length > 0) {
            listaNueva.forEach(RN => {
                ReportesAlmacenados.push(RN.ID);
                tiemposAlmacenados.push(RN.FechaNum);
                actualizarListas();
            });
        }
        else{
            console.log("No hay reportes pendientes de leer");
            actualizarListas();
        }
    }
}

function actualizarListas() {
    localStorage.setItem("RepIDs", ReportesAlmacenados);
    localStorage.setItem("RepFechas", tiemposAlmacenados);
    console.log(ReportesAlmacenados);
    console.log(tiemposAlmacenados);
}

function consultarTiempos() {
    var Tiempos = localStorage.RepFechas.split(',');
    console.log(Tiempos);
    const ahorita = Date.now();
    Tiempos.forEach(Hora => {
        console.log("Hora de la ultima noti: "+ Hora);
        console.log("Ahorita = " +Date.now());
        var horaNum = parseInt(Hora);
        const horaComp = horaNum+(2*minuto);
        
        console.log("UltimaNoti + 2min :" +horaComp);
        if (horaComp < ahorita) {
            Sonido.play();
            alert("Tienes reportes pendientes");
            indiceHora = tiemposAlmacenados.indexOf(horaNum);
            tiemposAlmacenados[indiceHora] = ahorita;
            actualizarListas();
        }

    });
}

firebase.auth().onAuthStateChanged(user => {
    if(user){
        hotel = localStorage.getItem('Hotel');
        contenidoChat(user)
    }else{
       console.log("sin usuario con sesion activa")
    }
})



const contenidoChat = (user) => {
   
    firebase.firestore().collection(hotel.toString()+"notif").orderBy('fecha')
    .onSnapshot(query => {
        query.forEach(notif =>{
            if(notif.data().uid === user.uid){
    
            }
            else {
                Sonido.play();
                alert(notif.data().mensaje);
                
                notif.ref.delete();
            }
        })           
    });
    

    firebase.firestore().collection(hotel.toString()+"message").orderBy('fecha')
    .onSnapshot(query => {
        query.forEach(notif =>{
            if(notif.data().uid === user.uid){

            }
            else {
                Sonido.play();
                alert(notif.data().mensaje);
                
                notif.ref.delete();
            }
        })           
    });

    firebase.firestore().collection(hotel.toString()+"status").orderBy('fecha')
    .onSnapshot(query => {
        query.forEach(notif =>{
            if(notif.data().uid === user.uid){

            }
            else {
                Sonido.play();
                alert(notif.data().mensaje);
                
                notif.ref.delete();
            }
        })           
    });

}