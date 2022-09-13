const cardInfoHabs = document.querySelector('.infoHabs');
const cardInfoReportes = document.querySelector('.infoReportes');
const cardInfoPersonal = document.querySelector('infoPersonal');
window.addEventListener('load', ()=>{
    fetch("../backendPagPrincipal/obtenerHabsDesocupadas.php", {
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

    fetch("../backendPagPrincipal/obtenerInfoReportes.php", {
        method:'POST'
    }).then(function(response){
        if(response.ok){               
            return response.text();                
        } else {
            throw "Error en la llamada Ajax"
        }      
    }).then(function(resHabs){
        console.log(resHabs);
        cardInfoReportes.textContent = "Hay " + resHabs + " Reportes pendientes";

    });

    fetch("../backendPagPrincipal/obtenerPersonalLimpieza.php", {
        method:'POST'
    }).then(function(response){
        if(response.ok){               
            return response.text();                
        } else {
            throw "Error en la llamada Ajax"
        }      
    }).then(function(resPers){
        console.log(resPers);
        cardInfoPersonal.textContent = "Hay " + resPers + " trabajadores de limpieza en horario labora";

    });
})

