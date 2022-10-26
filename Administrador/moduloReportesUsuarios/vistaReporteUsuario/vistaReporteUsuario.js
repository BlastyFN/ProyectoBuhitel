const botones = document.querySelector('.botones');
const formulario = document.querySelector('#envioMensaje');
const mensajeChat = document.querySelector('#mensajeChat');
const contenedorMensajes = document.querySelector('.contenedorMensajes');
const fragment = document.createDocumentFragment();
const titulo = document.querySelector('.titulo');
const categoria = document.querySelector('.categoria');
const estatus = document.querySelector('.estatus');
const fecha = document.getElementById("fecha");
const descripcionReporte = document.querySelector('.descripcionReporte');
const chat = document.querySelector('.chat');
const eleccionPersonal = document.querySelector('.eleccionPersonal');
const tipoPersonal = document.getElementById('tipoPersonal');
const obtenerReporteEspecifico = new FormData();
const listaPersonal = document.querySelector('.listaSeleccionPersonal');
const btnAsignar = document.querySelector('.asignarPersonal');
const obtenerListaPersonal = new FormData();
const btnSpam = document.querySelector('.spam');
const btnCompletado = document.querySelector('.completado');
const btnNotificar = document.querySelector('.notificar');
const divAcciones = document.querySelector('.acciones');
const personalAsignado = document.getElementById("PAsignado");
var reporteID;
var personal;
var hotel;


window.addEventListener('load', e => {
    hotel = localStorage.getItem('Hotel');
    obtenerReporteEspecifico.append("reporteID",localStorage.getItem("reporteID"));
    fetch('../backend/obtenerReporteEspecifico.php' , {
        method:'POST', body:obtenerReporteEspecifico
        
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }

    }).then(function(infoPersonal){
        console.log(infoPersonal);
        for(element of infoPersonal){
            reporteID = element.Reporte_ID;
            personal = element.Reporte_usuario;
            titulo.textContent = "Nombre: " + element.Reporte_Nombre;
            categoria.textContent = "Categoría: " + element.CatReporte_Nombre;
            estatus.textContent = "Estatus: " +element.EstatusReporte_Estatus;
            if (element.Reporte_Inicio != null) {
                fecha.textContent = "Fecha de asignación: " + element.Reporte_Inicio;
            }
            if (element.Personal_Nombre != null) {
                personalAsignado.textContent = "Asignado a: " + element.Personal_Nombre + " " + element.Personal_APaterno + " " + element.Personal_APaterno;
            }
            descripcionReporte.textContent = "Descripción: " +element.Reporte_Contenido;

            if (element.Reporte_usuario == null){
                eleccionPersonal.classList.add('activo');   
                console.log("no");
            } 
            else{
                chat.classList.add('activo');
                console.log("si");
            }
            if(element.CatReporte_Nombre != "Spam" || element.EstatusReporte_Estatus != "Completado"){
                divAcciones.classList.add('activo');
            }
        }

        definirBotonesHabilitados(element.Reporte_Estatus);

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

    if (estatus == "6"){
        chat.style.display = "none";   
        btnCompletado.style.display = "none";
        btnSpam.style.display = "none";
    }
}

const contenidoChat = (user) => {

        btnSpam.addEventListener('click', ()=> {
            const nombreCat = new FormData();
            nombreCat.append('nombre',"Spam");
            nombreCat.append('reporte', reporteID)
            fetch('../backend/modificarCategoria.php' , {
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
                    title: 'Se ha marcado como spam',
                    showConfirmButton: false,
                    timer: 2800
                }).then(()=>{
                
                    window.location.reload();
                });  
            })
        })



        function completarEnBd(){
            const nombreCat = new FormData();

            nombreCat.append('reporte', reporteID)
            fetch('../backend/completarReporte.php' , {
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
                    title: 'Se ha completado el reporte',
                    showConfirmButton: false,
                    timer: 2800
                }).then(()=>{
                
                    window.location.reload();
                });  
            })
        }

        firebase.firestore().collection(hotel.toString()+"notif").orderBy('fecha')
        .onSnapshot(query => {
            query.forEach(notif =>{
                if(notif.data().uid === user.uid){
        
                }
                else {
                    Sonido.play();
                    alert(notif.data().mensaje);
                    
                    notif.ref.delete();

                    setTimeout(() => {
                        if(notif.data().reload === true){
                            window.location.reload();
                        } 
                    }, 1000);
    
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

                    setTimeout(() => {
                        if(notif.data().reload === true){
                            window.location.reload();
                        } 
                    }, 1000);
    
                }
            })           
        });
    
        firebase.firestore().collection(hotel.toString()+"status").orderBy('fecha')
        .onSnapshot(query => {
            query.forEach(notif =>{
                if(notif.data().uid === user.uid){
    
                }
                else {
                    
                    alert(notif.data().mensaje);
                    
                    notif.ref.delete();

                    setTimeout(() => {
                        if(notif.data().reload === true){
                            window.location.reload();
                        } 
                    }, 1000);
    
                }
            })           
        });
    

}

tipoPersonal.addEventListener('change',() =>{
    const fragment = document.createDocumentFragment();
    btnAsignar.disabled=false;
    obtenerListaPersonal.append("tipo", tipoPersonal.value);
    fetch('../backend/obtenerListaPersonal.php' , {
        method:'POST', body:obtenerListaPersonal
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(lista){
        let inputs = Array.prototype.slice.call(document.getElementsByClassName("autogen"), 0);
        for(element of inputs){
            element.remove();
        }  
        console.log(lista);
        for(element of lista){
            const div = document.createElement('div');
            div.classList.add('autogen','elemento');
            const radioLbl = document.createElement('label');
            radioLbl.classList.add('formTextRadio', 'autogen');
            const radioBtn = document.createElement('input');
            radioBtn.classList.add('autogen','radioBtn');
            radioBtn.setAttribute('type','radio');
            radioBtn.setAttribute('name','radio');
            radioBtn.setAttribute('value', element.Personal_ID); 
            
            radioLbl.textContent = element.Personal_Nombre + " " + element.Personal_APaterno + 
            " " + element.Personal_AMaterno;
            
            div.appendChild(radioBtn);
            div.appendChild(radioLbl);
            fragment.appendChild(div);
            

        }
        listaPersonal.appendChild(fragment);
    })
})


function cambiarStatusEnBd(){
    const seguimiento = new FormData();
    var valorServicio;
    if(tipoPersonal.value == "Recepcion")valorServicio=4;
    else if(tipoPersonal.value == "Limpieza") valorServicio=5;
    else if(tipoPersonal.value == "Valet") valorServicio=3;
    else if(tipoPersonal.value == "Servicio") valorServicio=2;
    
    var valorPersonal = document.querySelector('input[name="radio"]:checked').value;
   
    seguimiento.append('personal',valorPersonal);
    seguimiento.append('servicio',valorServicio);
    seguimiento.append('reporteID', reporteID);
    fetch('../backend/asignarSeguimiento.php' , {
        method:'POST', body:seguimiento
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(texto){
  
    })
}





    formulario.addEventListener('submit',(e) =>{
        e.preventDefault()
        console.log(mensajeChat.value);
        if(!mensajeChat.value.trim()){
            console.log("input vacio")
            return
        }

        firebase.firestore().collection(hotel.toString() + "message").add({
            mensaje: localStorage.Nombre + ", Nuevo mensaje del administrador",
            uid: user.uid,
            fecha: Date.now(),
            personal: personal
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

        //                      --- Notificaciones ---
    btnAsignar.addEventListener('click', () => {
            cambiarStatusEnBd();
            firebase.firestore().collection(hotel.toString()+"notif").add({
                mensaje: "Has sido asignado a un reporte de seguimiento especial",
                uid: user.uid,
                fecha: Date.now(),
                 
            })
            .catch(e => console.log(e));
        })

    btnCompletado.addEventListener('click', ()=> {
            completarEnBd();
            firebase.firestore().collection(hotel.toString()+"notif").add({
                mensaje: "Se ha completado el reporte",
                uid: user.uid,
                fecha: Date.now()
            })
            .catch(e => console.log(e));
        })

        btnNotificar.addEventListener('click', ()=> {
        //completarEnBd();
        firebase.firestore().collection(hotel.toString()+"notif").add({
            mensaje: "El administrador pregunta por el estatus del reporte",
            uid: user.uid,
            fecha: Date.now()
        })
        .catch(e => console.log(e));
    })
    firebase.firestore().collection(hotel.toString()+"notif").orderBy('fecha')
    .onSnapshot(query => {
        query.forEach(notif =>{
            if(notif.data().uid === user.uid){
 
            }
            else {
                alert(notif.data().mensaje);
                notif.ref.delete();
                if(notif.data().reload === true){
                    window.location.reload();
                }
            }
        })           
    });
    firebase.firestore().collection(hotel.toString()+"status").orderBy('fecha')
    .onSnapshot(query => {
        query.forEach(notif =>{
            if(notif.data().uid === user.uid){

            }
            else {
                notif.ref.delete();
                Sonido.play();
                alert(notif.data().mensaje);
                
                setTimeout(() => {
                    if(notif.data().reload === true){
                        window.location.reload();
                    } 
                }, 1000);

            }
        })           
    });










