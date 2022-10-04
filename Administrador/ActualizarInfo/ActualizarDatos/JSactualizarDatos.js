const campoPregunta = document.getElementById("NPregunta");
const btnActualizar = document.getElementById("btnActualizar");


window.addEventListener("load", function () {
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
            var informacion = JSON.parse(texto);
            console.log(informacion);
            console.log(informacion.Twilio_PreguntaAbierta);
            if (informacion.Twilio_PreguntaAbierta !=  null) {
                campoPregunta.value = informacion.Twilio_PreguntaAbierta;
            }
            else{
                campoPregunta.value = "¿Cuál es tu opinión en general del hotel?";
            }
            
            
        }
     })
     .catch(function(err) {
        console.log(err);
     }); 
});

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
