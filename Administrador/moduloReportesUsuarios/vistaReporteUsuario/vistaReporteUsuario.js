const botones = document.querySelector('.botones');
const formulario = document.querySelector('#envioMensaje');
const mensajeChat = document.querySelector('#mensajeChat');
const contenedorMensajes = document.querySelector('.contenedorMensajes');
const fragment = document.createDocumentFragment();
const titulo = document.querySelector('.titulo');
const categoria = document.querySelector('.categoria');
const estatus = document.querySelector('.estatus');
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
const divAcciones = document.querySelector('.acciones');
var reporteID;


window.addEventListener('load', e => {
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

            titulo.textContent = element.Reporte_Nombre;
            categoria.textContent = element.CatReporte_Nombre;
            estatus.textContent = element.EstatusReporte_Estatus;
            descripcionReporte.textContent = element.Reporte_Contenido;
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
    })
})

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
        
    })
})

btnCompletado.addEventListener('click', ()=> {
    const nombreCat = new FormData();
    nombreCat.append('nombre',"Spam");
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
        
    })
})

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

btnAsignar.addEventListener('click', () => {
    const seguimiento = new FormData();
    var valorServicio;
    if(tipoPersonal.value == "Recepcion")valorServicio=4;
    else if(tipoPersonal.value == "Limpieza") valorServicio=5;
    else if(tipoPersonal.value == "Valet") valorServicio=3;
    else if(tipoPersonal.value == "Servicio") valorServicio=2;
    
    var valorPersonal = document.querySelector('input[name="radio"]:checked').value;
   
    seguimiento.append('personal',valorPersonal);
    seguimiento.append('servicio',valorServicio);
    seguimiento.append('reporteID', reporteID)/8
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
})


firebase.auth().onAuthStateChanged(user => {
    if(user){
       
        contenidoChat(user)
    }else{
       console.log("sin usuario con sesion activa")
    }
})




const contenidoChat = (user) => {
    console.log(user);
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





