const verificar = document.querySelector('#BtnVerificar');
const contenedor = document.querySelector('#ContenedorInfo');
const cmpHabitacion = document.getElementById('cmpHabitacion');
const cmpfecha = document.getElementById('cmpHora');
const formLimp = document.getElementById('FormularioLimpieza');
class TarjetaLimpieza {
    constructor(habitacion, color, nombre, apellidos, inicio, fin, id){
        this.habitacion = habitacion;
        this.color = color;
        this.nombre = nombre;
        this.apellidos = apellidos;
        this.inicio = inicio;
        this.fin = fin;
        this.id = id;
    }
    get HTML() {
        return this.obtenerHTML();
    }
    obtenerHTML(){
       //NODOS DE TEXTO
       var NodoTitulo = document.createTextNode(this.habitacion);
       var NodoNombre = document.createTextNode(this.nombre);
       var NodoApellidos = document.createTextNode(this.apellidos);
       var NodoInicio = document.createTextNode(this.inicio);
       var NodoFin = document.createTextNode(this.fin);
       var NodoBoton = document.createTextNode("Cancelar");
        //Div general
        var iTarjeta = document.createElement('div');
        iTarjeta.classList.add('Tarjeta');
        iTarjeta.classList.add(this.color);
        iTarjeta.setAttribute("id", "TarLimpieza");
        //Titulo Tarjeta
        var iTitulo = document.createElement('h1');
        iTitulo.classList.add('Info');
        iTitulo.appendChild(NodoTitulo);
        //Div info
        var iInformacion = document.createElement('div');
        iInformacion.classList.add('Info');
        //INFORMACIÓN
        var iNombre = document.createElement('p');
        iNombre.appendChild(NodoNombre);
        var iApellidos = document.createElement('p');
        iApellidos.appendChild(NodoApellidos);
        var iInicio = document.createElement('p');
        iInicio.appendChild(NodoInicio);
        var iFin = document.createElement('p');
        iFin.appendChild(NodoFin);
        
        iInformacion.appendChild(iNombre);
        iInformacion.appendChild(iApellidos);
        iInformacion.appendChild(iInicio);
        iInformacion.appendChild(iFin);
        //BOTON 
        var iBoton = document.createElement('button');
        iBoton.classList.add('Naranja');
        iBoton.classList.add('ModelBtn');
        iBoton.classList.add('Ult');
        iBoton.appendChild(NodoBoton);
        iBoton.setAttribute('value', this.id);
        iBoton.addEventListener('click', cancelar);
        //Integrar todo en tarjeta
        iTarjeta.appendChild(iTitulo);
        iTarjeta.appendChild(iInformacion);
        iTarjeta.appendChild(iBoton);
        return iTarjeta;
    }
}
verificar.addEventListener("click", function (e) {
    e.preventDefault();

    solicitarLimpieza();

});


window.addEventListener('load', function () {
    console.log(localStorage.EditarLimpieza);
   if (localStorage.EditarLimpieza == "true") {
       console.log("Editar");
       cmpHabitacion.value = localStorage.LimpHabitacion;
       cmpfecha.value = localStorage.LimpInicio;
       localStorage.EditarLimpieza = false;
   } 
});

function solicitarLimpieza() {
    const infoLimpieza = new FormData(formLimp);
    fetch('../backend/solicitudLimpieza.php', {
        method:'POST',
        body: infoLimpieza
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        console.log(texto);
        while (contenedor.firstChild) {
            contenedor.removeChild(contenedor.firstChild);
        }
        if (texto == "0") {
            alert("Habitación inválida")
        }
        if (texto == "NP") {
            alert("No hay persobal trabajando a esa hora");
        }
        else{
            infoJSON = JSON.parse(texto);
            
            if (infoJSON.Habitacion != undefined) {
                const Tar = new TarjetaLimpieza(infoJSON.Habitacion, "Azul", infoJSON.Nombre, infoJSON.Apellidos, infoJSON.Inicio, infoJSON.Final, infoJSON.ID);
                contenedor.appendChild(Tar.HTML);
            }
            else{
                console.log(infoJSON);
                generarHorario(infoJSON);
            }
        }
     })
     .catch(function(err) {
        console.log(err);
     });
}

function cancelar() {
    const infoCancelar = new FormData();
    infoCancelar.append('Limpieza', this.value);
    fetch('../backend/cancelarLimpieza.php', {
        method:'POST',
        body: infoCancelar
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        while (contenedor.firstChild) {
            contenedor.removeChild(contenedor.firstChild);
        }
        alert(texto);
     })
     .catch(function(err) {
        console.log(err);
     });

}

function generarHorario(Horario) {
    alert("Horario no disponible!");
    var contenedorHorario = document.createElement('div');
    contenedorHorario.classList.add('TextosCentrados');
    var Titulo = document.createElement('h1');
    Titulo.innerHTML = "Disponibilidad";
    contenedorHorario.appendChild(Titulo);
    var contador = 1;
    var textoAcumulado;
    Horario.forEach(element => {
        var Hora = element.slice(element.indexOf(" "));
        if (contador%2==0) {
            
            textoAcumulado += Hora;
            console.log(textoAcumulado);
            var Periodo = document.createElement('h1');
            Periodo.innerHTML = textoAcumulado;
            contenedorHorario.appendChild(Periodo);
        }
        else{
            textoAcumulado = "De " + Hora +" A";
        }
        contador++;
 
    });
    contenedor.appendChild(contenedorHorario);
}