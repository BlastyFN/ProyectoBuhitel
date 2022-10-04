const campoPregunta = document.getElementById("NPregunta");
const btnActualizar = document.getElementById("btnActualizar");
const contRespuestas = document.getElementById("Respuestas");

window.addEventListener("load", function () {
    cargarPregunta();
    cargarRespuestas();
});

function cargarPregunta() {
    fetch ('../backend/obtenerDatos.php', {
        method:'POST'
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        if (texto == "0") {

        }
        else{
            if (texto != null) {
                var informacion = JSON.parse(texto);
                console.log(informacion);
                console.log(informacion.Twilio_PreguntaAbierta);
                campoPregunta.value = informacion.Twilio_PreguntaAbierta;
            }else{
                campoPregunta.value = "¿Cuál es tu opinión en general del hotel?";
            }        
        }
     })
     .catch(function(err) {
        console.log(err);
     }); 
}

function cargarRespuestas() {
    fetch ('../backend/obtenerRespuestas.php', {
        method:'POST'
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        if (texto == "0") {
            alert("No hay respuestas");
        }
        else{

            var informacion = JSON.parse(texto);
            console.log(informacion);
            console.log(informacion);
            informacion.forEach(element => {
                console.log(element);
                console.log(element.Respuesta_Valor);
                var fila = document.createElement('p');
                fila.innerHTML = "R: "+element.Respuesta_Valor;
                var salto = document.createElement('br');
                contRespuestas.appendChild(fila);
                contRespuestas.appendChild(salto);
            });

        }
     })
     .catch(function(err) {
        console.log(err);
     }); 
}

btnActualizar.addEventListener("click", function (e) {
    e.preventDefault();
    const infoActualizar = new FormData();
    infoActualizar.append("Pregunta", campoPregunta.value);
    fetch ('../backend/nuevosDatos.php', {
        method:'POST',
        body: infoActualizar
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        alert(texto);
     })
     .catch(function(err) {
        console.log(err);
     }); 
});
