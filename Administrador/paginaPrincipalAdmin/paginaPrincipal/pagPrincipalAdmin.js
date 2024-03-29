const cardInfoHabs = document.querySelector('.infoHabs');
const cardInfoReportes = document.querySelector('.infoReportes');
const cardInfoPersonal = document.querySelector('.infoPersonal');
const cardInfoEstadistica = document.querySelector('.infoEstadistica');
window.addEventListener("load", cargarInfo);
var intervalo = window.setInterval(cargarInfo, 10000);


function cargarInfo() {
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
        cardInfoHabs.textContent = resHabs;

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
        cardInfoReportes.textContent = "Hay " + resHabs + " reportes pendientes";

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
        cardInfoPersonal.textContent = "Hay " + resPers + " trabajadores de limpieza en horario laboral";

    });

    fetch("../backendPagPrincipal/obtenerDatoEstadistico.php", {
        method:'POST'
    }).then(function(response){
        if(response.ok){               
            return response.text();                
        } else {
            throw "Error en la llamada Ajax"
        }      
    }).then(function(resEstad){
        console.log(resEstad);
        cardInfoEstadistica.textContent =  resEstad ;

    });
}
