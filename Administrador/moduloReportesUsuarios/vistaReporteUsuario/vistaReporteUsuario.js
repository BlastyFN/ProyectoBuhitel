const botones = document.querySelector('.botones');
const formulario = document.querySelector('#envioMensaje');
const mensajeChat = document.querySelector('#mensajeChat');
const contenedorMensajes = document.querySelector('.contenedorMensajes');
const fragment = document.createDocumentFragment();
const titulo = document.querySelector('.titulo');
const obtenerReporteEspecifico = new FormData();

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
            titulo.textContent = element.Reporte_Nombre;
            
        }
    })
})

firebase.auth().onAuthStateChanged(user => {
    if(user){
        accionCerrarSesion()
        contenidoChat(user)
    }else{
        accionAcceder()
        console.log('usuario no registrado')

    }
})

const contenidoChat = (user) => {
    formulario.addEventListener('submit',(e) =>{
        e.preventDefault()
        console.log(mensajeChat.value);
        if(!mensajeChat.value.trim()){
            console.log("input vacio")
            return
        }
        firebase.firestore().collection('chatBuhitel').add({
            mensaje: mensajeChat.value,
            uid: user.uid,
            fecha: Date.now()
        })
        .then(res => {console.log("Mensaje guardado")
        mensajeChat.value = ''})
        .catch(e => console.log(e));        
    })

    firebase.firestore().collection('chatBuhitel').orderBy('fecha')
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

const accionAcceder = () => {

    botones.innerHTML = /*html*/`
        <button class="btnAcc" id="btnAcceder">Acceder</button>
    `
    
   const btnAcceder = document.querySelector('#btnAcceder')    
    btnAcceder.addEventListener('click', async() => {
        console.log('entro')
        const provider = new firebase.auth.GoogleAuthProvider();
        try {
            await firebase.auth().signInWithPopup(provider)
        } catch (error) {
            console.log(error)
        }
    })

}

const accionCerrarSesion = () => {
    botones.innerHTML = /*html*/`
        <button class="btn btn-outline-danger" id="btnCerrar">Cerrar Sesión</button>
    `
    const btnCerrar = document.querySelector('#btnCerrar')
    btnCerrar.addEventListener('click', () => firebase.auth().signOut())
}



