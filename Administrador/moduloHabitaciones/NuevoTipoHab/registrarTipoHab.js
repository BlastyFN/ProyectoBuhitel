const ingresarTipoForm = document.querySelector('.ingresarTipoForm');
console.log(ingresarTipoForm);
const enviarTipo = new FormData();
const inputNombreTipo = document.getElementById('nombreTipo');
const inputPrecio = document.getElementById('precioTipo');
const inputNumCamas = document.getElementById('numCamas');
const inputLimpNormal = document.getElementById('tiempoLimpNormal');
const inputLimpProf = document.getElementById('tiempoLimpProf');
const valueLimpNormal = inputLimpNormal.value;
console.log(valueLimpNormal);


ingresarTipoForm.addEventListener('submit', function(e){
    e.preventDefault();
    var valorNombre = inputNombreTipo.value;
    enviarTipo.append('nombre',valorNombre);
    var valorPrecio = inputPrecio.value;
    enviarTipo.append('precio',valorPrecio);
    var valorNumCamas = inputNumCamas.value;
    enviarTipo.append('numCamas',valorNumCamas);
    var valueLimpNormal = inputLimpNormal.value;
    enviarTipo.append('limpNormal',valueLimpNormal);
    var ValorLimpProf = inputLimpProf.value;
    enviarTipo.append('limpProf',ValorLimpProf);
   
    

    fetch('../backend/registrarTipoHab.php' , {
        method:'POST', body:enviarTipo
    }).then(function(response){
        if(response.ok){
         return response.text();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(texto){
        console.log(texto);
        alert(texto);
    })
});