const contenedorCartas = document.querySelector('.containCards');
const fragment = document.createDocumentFragment();



window.addEventListener('load', e => {
    fetch('../BackendReportes/obtenerReportes.php' , {
        method:'POST'
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(listaReportes){
        console.log(listaReportes);
        for(reporte of listaReportes){
            const divContIndividual = document.createElement('div');
            divContIndividual.classList.add('contIndividual');

            const divCardBoard = document.createElement('div');
            divCardBoard.classList.add('cardBoard');
            divCardBoard.textContent = reporte.Reporte_Nombre;

            const divCard = document.createElement('div');
            divCard.id = reporte.Reporte_ID;
            divCard.classList.add('card','infoHabs','ver');
            divCard.textContent = "Tipo de reporte: " + reporte.CatReporte_Nombre;

            const labelMensajes = document.createElement('label');
            labelMensajes.textContent = "0 mensajes sin ver";

            divCard.appendChild(document.createElement('br'));
            divCard.appendChild(labelMensajes);
            divContIndividual.appendChild(divCardBoard);
            divContIndividual.appendChild(divCard);
            fragment.appendChild(divContIndividual);


        }
        contenedorCartas.appendChild(fragment);
    })
})

document.addEventListener('DOMContentLoaded', () => {

    contenedorCartas.addEventListener('click', e =>{
        if(e.target.classList.contains('ver')){
            var reporteID = e.target.id;
            //enviarID.append('id',e.reporteID);
            localStorage.setItem("reporteID", reporteID);
            window.location.href="https://corporativotdo.com/General/SolucionDeReportes/VistaReporte/VistaReporte.php";
           
        }
    })

})


firebase.auth().onAuthStateChanged(user => {
    if(user){
       
        contenidoChat(user)
    }else{
       console.log("sin usuario con sesion activa")
    }
})



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







const contenidoChat = (user) => {
   
    firebase.firestore().collection(reporteID.toString()+"notif").orderBy('fecha')
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
    

firebase.firestore().collection(reporteID.toString()+"message").orderBy('fecha')
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


