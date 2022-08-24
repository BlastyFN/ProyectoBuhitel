const botones = document.querySelector('.botones');
const formulario = document.querySelector('#envioMensaje');
const mensajeChat = document.querySelector('#mensajeChat');
const contenedorMensajes = document.querySelector('.contenedorMensajes');
const fragment = document.createDocumentFragment();
const titulo = document.querySelector('.titulo');
const descripcionReporte = document.querySelector('.descripcionReporte');
const chat = document.querySelector('.chat');

const userKey = Object.keys(window.sessionStorage);
const user = userKey ? JSON.parse(sessionStorage.getItem(userKey)) : undefined;
const obtenerReporteEspecifico = new FormData();

const obtenerListaPersonal = new FormData();
var reporteID;

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
            titulo.textContent = element.Reporte_Nombre;
            descripcionReporte.textContent = element.Reporte_Contenido;
           
            contenidoChat(user);
        }
        
    })
})





const contenidoChat = (user) => {
    formulario.addEventListener('submit',(e) =>{
        e.preventDefault()
        console.log(mensajeChat.value);
        if(!mensajeChat.value.trim()){
            console.log("input vacio")
            return
        }
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
}



