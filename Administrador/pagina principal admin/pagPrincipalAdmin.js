const cardInfoHabs = document.querySelector('.infoHabs');

window.addEventListener('load', ()=>{
    fetch("backendPagPrincipal/obtenerHabsDesocupadas.php", {
        method:'POST'
    }).then(function(response){
        if(response.ok){               
            return response.text();                
        } else {
            throw "Error en la llamada Ajax"
        }      
    }).then(function(resHabs){
        console.log(resHabs);
        cardInfoHabs.textContent = "Hay " + resHabs + " Habitaciones desocupadas";

    });
})