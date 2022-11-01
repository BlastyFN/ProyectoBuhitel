

const formConfInicial = document.getElementById('btnEnviar');
console.log(formConfInicial);
const definirPisos = document.getElementById('input_NumPisos');


definirPisos.addEventListener('keyup', definirNumPisos);

function definirNumPisos(){
    let inputs = Array.prototype.slice.call(document.getElementsByClassName("autogen"), 0);
    console.log(inputs);
    for(element of inputs){
        element.remove();
      }  

    const contInputs = document.querySelector('.contInputPisos');
    const fragment = document.createDocumentFragment();
    for(var cont = 0; cont < definirPisos.value ; cont++){
        piso = cont + 1;
        const inputPiso = document.createElement('input');
        inputPiso.setAttribute("type","number");
        inputPiso.setAttribute("required","true");
        inputPiso.placeholder = "Numero de habitaciones del piso " + piso;
        inputPiso.classList.add('formText','autogen');
        fragment.appendChild(inputPiso);
    }
    contInputs.appendChild(fragment);
}


formConfInicial.addEventListener('click', function(e){
    e.preventDefault();
    let inputs = Array.prototype.slice.call(document.getElementsByClassName("autogen"), 0);
    var values = new Array();
    for (element of inputs){
        values.push(element.value);
    }
    // for(var cont = 0; cont < inputs.length; cont++){
    //     var numPiso = cont + 1;
    //     var numHabs = inputs[cont].value;
    //     console.log(numPiso + " tiene " + numHabs);
    //   }  



    const enviarConfig = new FormData();
    const numPisos = inputs.length;
    const jsonNumHabs = JSON.stringify(values);
    
    enviarConfig.append('pisos', numPisos);
    enviarConfig.append('numHabs',jsonNumHabs);


    fetch('../backend/configInicialHabitaciones.php' , {
        method:'POST', body:enviarConfig
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
            title: 'Se ha guardado la configuración',
            showConfirmButton: false,
            timer: 2500
        }).then(()=>{
            window.location.href = "https://corporativotdo.com/Administrador/moduloHabitaciones/VistaGeneralHab/vistaGeneralHab.php";
        });
    })
});



