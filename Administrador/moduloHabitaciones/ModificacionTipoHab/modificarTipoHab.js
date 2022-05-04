const opciones = document.getElementById('opcDesplegable');
const fragment = document.createDocumentFragment();
const btnEnviar = document.querySelector('.enviarInfo');
var inputNombreTipo = document.getElementById('nombreTipo');

var inputPrecio = document.getElementById('precioTipo');
var inputNumCamas = document.getElementById('numCamas');
var inputLimpNormal = document.getElementById('tiempoLimpNormal');
var inputLimpProf = document.getElementById('tiempoLimpProf');


addEventListener('load', function(e){   //Función para llamar el select
    cargarOpciones();
});


opciones.addEventListener('change', function(e){
    e.preventDefault();
    cargarInfoTipoHab(opciones.value);
    
});

btnEnviar.addEventListener('click', function(e){
    e.preventDefault();
    const enviarInfo = new FormData();
    enviarInfo.append('ID',opciones.value);
    var valorNombre = inputNombreTipo.value;
    enviarInfo.append('nombre',valorNombre);
    var valorPrecio = inputPrecio.value;
    enviarInfo.append('precio',valorPrecio);
    var valorNumCamas = inputNumCamas.value;
    enviarInfo.append('numCamas',valorNumCamas);
    var valueLimpNormal = inputLimpNormal.value;
    enviarInfo.append('limpNormal',valueLimpNormal);
    var ValorLimpProf = inputLimpProf.value;
    enviarInfo.append('limpProf',ValorLimpProf);
   
    

    fetch('../backend/modificarTipoHab.php' , {
        method:'POST', body:enviarInfo
    }).then(function(response){
        if(response.ok){
         return response.text();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(texto){
        console.log(texto);
        alert(texto);

        for(element in opciones){
            opciones.remove(element);
        }
        cargarOpciones();
        cargarInfoTipoHab(opciones.value);
       

    })
});

function cargarOpciones(){
    this.preventDefault;
    fetch('../backend/obtenerTiposDeHabs.php' , {
        method:'POST'
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(texto){
        for(element of texto){  //Por cada elemento del json
            console.log(texto);
            var inputTipoHab = document.createElement('option');
            inputTipoHab.setAttribute('value',element.tipohab_ID);
            inputTipoHab.textContent = element.tipohab_nombre;
            console.log(inputTipoHab.value);
            fragment.appendChild(inputTipoHab);
            
        }
        
        opciones.appendChild(fragment);
        cargarInfoTipoHab(opciones.value);
    });
}

function cargarInfoTipoHab(ID){
    this.preventDefault;
    const solicitarTipo = new FormData();
    solicitarTipo.append("tipohab_ID",ID);
    fetch("../backend/obtenerTipoDeHab.php", {
        method:'POST', body: solicitarTipo
    }).then(function(response){
        if(response.ok){
            return response.json();
           } else {
               throw "Error en la llamada Ajax"
           }      
    }).then(function(res){

        inputNombreTipo.value = res[0].TipoHab_Nombre;
        console.log("nom" + res[0].TipoHab_Nombre);
        inputPrecio.value =  res[0].TipoHab_Precio;
        console.log("presio" + res[0].TipoHab_Precio);
        inputNumCamas.value = res[0].TipoHab_NumCamas;
        console.log("camas" + res[0].TipoHab_NumCamas);
        inputLimpNormal.value = res[0].TipoHab_TiempoLimpNormal;
        inputLimpProf.value =  res[0].TipoHab_TiempoLimpProfunda;

        

    });
    
}