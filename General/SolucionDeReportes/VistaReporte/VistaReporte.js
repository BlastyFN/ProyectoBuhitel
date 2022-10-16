const botones = document.querySelector('.botones');
const formulario = document.querySelector('#envioMensaje');
const mensajeChat = document.querySelector('#mensajeChat');
const contenedorMensajes = document.querySelector('.contenedorMensajes');
const fragment = document.createDocumentFragment();
const titulo = document.querySelector('.titulo');
const descripcionReporte = document.querySelector('.descripcionReporte');
const chat = document.querySelector('.chat');
const btnIniciar = document.querySelector('.iniciar');
const btnCompletado = document.querySelector('.completado');


const obtenerReporteEspecifico = new FormData();

const obtenerListaPersonal = new FormData();
var reporteID, reporteUsuario;

window.addEventListener('load', e => {
    obtenerReporteEspecifico.append("reporteID",localStorage.getItem("reporteID"));
    fetch('../BackendReportes/obtenerReporte.php' , {
        method:'POST', body:obtenerReporteEspecifico
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(infoPersonal){
        console.log(infoPersonal);
        for( element of infoPersonal){
            reporteID = element.Reporte_ID;
            reporteUsuario = element.Reporte_usuario;
            titulo.textContent = element.Reporte_Nombre;
            descripcionReporte.textContent = element.Reporte_Contenido;
            
            if(element.Reporte_Estatus == "2"){
                marcarReporteVisto(reporteID);
            }
            else{
                console.log(element.Reporte_Estatus);
            }
        }
        
    })
})

function marcarReporteVisto(reporteID){
    const datosReporte = new FormData();
    datosReporte.append(reporteID);
    fetch('../BackendReportes/marcarReporteVisto.php' , {
        method:'POST', body: datosReporte
    }).then(function(response){
        if(response.ok){
         return;
        } else {
            throw "Error en la llamada Ajax"
        }
    });
}

firebase.auth().onAuthStateChanged(user => {
    if(user){
       
        contenidoChat(user)
    }else{
       console.log("sin usuario con sesion activa")
    }
})

function iniciarEnBd(){
    const nombreCat = new FormData();

    nombreCat.append('reporte', reporteID)
    fetch('../BackendReportes/iniciarReporte.php' , {
        method:'POST', body:nombreCat
    }).then(function(response){
        if(response.ok){
         return response.text();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(texto){
        
    })
}


function completarEnBd(){
    const nombreCat = new FormData();

    nombreCat.append('reporte', reporteID)
    fetch('../BackendReportes/completarReporte.php' , {
        method:'POST', body:nombreCat
    }).then(function(response){
        if(response.ok){
         return response.text();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(texto){
        
    })
}



const contenidoChat = (user) => {
    formulario.addEventListener('submit',(e) =>{
        e.preventDefault()
        console.log(mensajeChat.value);
        if(!mensajeChat.value.trim()){
            console.log("input vacio")
            return
        }

        firebase.firestore().collection("message").add({
            mensaje: "Nuevo mensaje de " + localStorage.Nombre,
            uid: user.uid,
            fecha: Date.now()
        })
        .catch(e => console.log(e)); 

        firebase.firestore().collection(reporteID.toString()).add({
            mensaje: mensajeChat.value,
            uid: user.uid,
            fecha: Date.now()
        })
        .then(res => {console.log("Mensaje guardado")
        mensajeChat.value = ''})
        .catch(e => console.log(e));
                    
    })

    firebase.firestore().collection(reporteID.toString()).orderBy('fecha')
    .onSnapshot(query => {
        contenedorMensajes.innerHTML = "";
        query.forEach(mensaje => {
            console.log(mensaje.data());
            if(mensaje.data().uid === user.uid){
                var divMensaje = document.createElement('div');
                divMensaje.classList.add('mensajeEnviado');
                const spanMensaje = document.createElement('span');
                spanMensaje.textContent = mensaje.data().mensaje;
                divMensaje.appendChild(spanMensaje);
                fragment.appendChild(divMensaje);
            }
            else{
                var divMensaje = document.createElement('div');
                divMensaje.classList.add('mensajeRecibido');
                const spanMensaje = document.createElement('span');
                spanMensaje.textContent =  mensaje.data().mensaje;
                divMensaje.appendChild(spanMensaje);
                fragment.appendChild(divMensaje);   
            }
            
        });
        contenedorMensajes.appendChild(fragment);
        contenedorMensajes.scrollTop = contenedorMensajes.scrollHeight;
    })

    btnCompletado.addEventListener('click', ()=> {
        completarEnBd();
        firebase.firestore().collection("notif").add({
            mensaje: localStorage.Nombre + " ha completado el seguimiento de reporte",
            uid: user.uid,
            fecha: Date.now()
        })
        .catch(e => console.log(e));
    })



firebase.firestore().collection("notif").orderBy('fecha')
.onSnapshot(query => {
    query.forEach(notif =>{
        if(notif.data().uid === user.uid){

        }
        else {
            alert(notif.data().mensaje);
            notif.ref.delete();
        }
    })           
});
}



