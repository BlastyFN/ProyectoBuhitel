var hotel;
const Sonido = new Audio("/Recursos/Campana.mp3");

var intervalo = window.setInterval(consultarReportes, 10000);


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
        console.log(texto);
        let info = JSON.parse(texto);
        console.log(info);
     })
     .catch(function(err) {
        console.log(err);
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