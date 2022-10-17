var hotel;
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
                alert(notif.data().mensaje);
                notif.ref.delete();
            }
        })           
    });

}