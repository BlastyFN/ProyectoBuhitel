const Campos = document.getElementsByTagName('input');
const NCampos = document.querySelectorAll('input');
const LineasVehiculo = document.querySelectorAll('tbody > tr');
const CampoHabitacion = document.getElementById("cmpHabitacion");
const btnConfirmar = document.getElementById('btnConfirmar');
const infoVehiculo = document.getElementById("InfoVehiculo");
function verificarBoton() {
    contador = 0;
    NCampos.forEach(element => {
        if (element.value != "") {
            contador++    
        }
        
    });
    if (contador == 6) {
        
         btnConfirmar.disabled = false;
    }
    else{
        btnConfirmar.disabled = true;
    }
}


NCampos.forEach(element => {
    element.addEventListener('keyup', verificarBoton);
});

LineasVehiculo.forEach(element =>{
    element.addEventListener('click', function (e) {
       let Habitacion = this.querySelector('td');
       alert (Habitacion.textContent);
    });
});

btnConfirmar.addEventListener('click', function (e) {
    e.preventDefault();
    
        const infoHab = new FormData(infoVehiculo);
        // infoHab.append('Habitacion', CampoHabitacion.value);
        fetch('../backend/consultaHuesped.php', {
            method:'POST',
            body: infoHab
        })
        .then(function(response){
            if(response.ok) {
                return response.text();
            } else {
                throw "Error en la llamada Ajax";
            }
        })
        .then(function(texto) {
            if (texto == '0') {
                // alert("Tobien");
                alert("La habitacion no está ocupada o no existe");
                btnConfirmar.disabled = true;
                
            }
            else{
                console.log(texto);
            }
         })
         .catch(function(err) {
            console.log(err);
         });
});