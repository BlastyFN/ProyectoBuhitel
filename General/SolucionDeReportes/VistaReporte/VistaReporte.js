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
const txtCatReporte = document.getElementById("catReporte");
const txtStatReporte = document.getElementById("estatReporte");
const txtFechaReporte = document.getElementById("asignacion");
const obtenerReporteEspecifico = new FormData();

const obtenerListaPersonal = new FormData();
var reporteID, reporteUsuario, hotel;

window.addEventListener('load', e => {
    hotel = localStorage.getItem('Hotel');
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
            titulo.textContent = "Nombre: " + element.Reporte_Nombre;
            txtFechaReporte.textContent = "Fecha de asignación: " + element.Reporte_Inicio;
            txtStatReporte.textContent = "Estatus: " + element.EstatusReporte_Estatus;
            txtCatReporte.textContent = "Categoría: " + element.CatReporte_Nombre;
            descripcionReporte.textContent = "Descripción: "+element.Reporte_Contenido;
            console.log(element.Reporte_Estatus);
            if(element.Reporte_Estatus == "2"){
                marcarReporteVisto(reporteID);
                element.Reporte_Estatus = "3";
            }
            else{
                console.log(element.Reporte_Estatus);
            }
            definirBotonesHabilitados(element.Reporte_Estatus);
        }
        firebase.auth().onAuthStateChanged(user => {
            if(user){
               
                contenidoChat(user)
            }else{
               console.log("sin usuario con sesion activa")
            }
        })
    })
})

function definirBotonesHabilitados(estatus) {
    if(estatus != "4"){
        btnCompletado.style.display = "none";
    }
    
    if (estatus != "3"){
        btnIniciar.style.display = "none";
    }

    if (estatus == "6"){
        chat.style.display = "none";   
    }
  }

function marcarReporteVisto(reporteID){
    const datosReporte = new FormData();
    datosReporte.append("reporteID",reporteID);
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



const contenidoChat = (user) => {

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
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Se ha iniciado el seguimiento del reporte',
                showConfirmButton: false,
                timer: 2800
            }).then(()=>{
                firebase.firestore().collection(hotel.toString()+"status").add({
                    mensaje: localStorage.Nombre + " ha iniciado el seguimiento ",
                    uid: user.uid,
                    fecha: Date.now(),
                    reload: true
                })
                .catch(e => console.log(e)); 
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
                
            });  
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
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'has completado el reporte',
                showConfirmButton: false,
                timer: 2800
            }).then(()=>{
                firebase.firestore().collection(hotel.toString()+"status").add({
                    mensaje: localStorage.Nombre + " ha completado el reporte",
                    uid: user.uid,
                    fecha: Date.now()
                })
                .catch(e => console.log(e)); 
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
                
            });  
        })
    }

    formulario.addEventListener('submit',(e) =>{
        e.preventDefault()
        console.log(mensajeChat.value);
        if(!mensajeChat.value.trim()){
            console.log("input vacio")
            return
        }

        firebase.firestore().collection(hotel.toString()+"message").add({
            mensaje: "Nuevo mensaje de " + localStorage.Nombre,
            uid: user.uid,
            fecha: Date.now()
        })
        .catch(e => console.log(e)); 

        firebase.firestore().collection(reporteID).add({
            mensaje: mensajeChat.value,
            uid: user.uid,
            fecha: Date.now()
        })
        .then(res => {console.log("Mensaje guardado")
        mensajeChat.value = ''})
        .catch(e => console.log(e));
                    
    })

    firebase.firestore().collection(reporteID).orderBy('fecha')
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

    btnIniciar.addEventListener('click', ()=>{
        console.log("click en iniciar");
        iniciarEnBd();
    })

    btnCompletado.addEventListener('click', ()=> {
        completarEnBd();
        firebase.firestore().collection("notif").add({
            mensaje: localStorage.Nombre + " ha completado el seguimiento de reporte",
            uid: user.uid,
            fecha: Date.now(),
            reload: true
        })
        .catch(e => console.log(e));
        window.location.href = "https://corporativotdo.com/General/SolucionDeReportes/VistaGeneralReportes/VistaGeneralReportes.php";

    })



    firebase.firestore().collection(hotel.toString()+"notif").orderBy('fecha')
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



