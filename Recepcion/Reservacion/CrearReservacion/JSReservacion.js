const btnAdd = document.querySelector('#addImput'); //Obtiene el botón añadir
const contenedor = document.querySelector('#Entradas');  //Obtiene el div en el que están las entradas

var tipos; //= document.getElementsByClassName('Original'); Obtiene las opciones otorgadas por el PHP
var STipos = document.querySelectorAll('.STipo');
var SHabitaciones = document.querySelectorAll('.SHabitacion');

//Cargar documento
window.addEventListener("load", function(e){
    const xhttp = new XMLHttpRequest();
    xhttp.open('GET', 'Tipos.json', true);
    xhttp.send();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) { 
            tipos = JSON.parse(this.responseText);
            crearLinea(1);
        }
    }
    
    
});
//Crear events listeners a los SELECTS de TIPOS



//Contador de Habitaciones
var contador = 0;
//Evento de click en el botón Añadir
btnAdd.addEventListener("click", function(e){
    e.preventDefault();
    //Verifica el límite permitido de habitaciones por reservacion (5)
    if (contador<4) {
       crearLinea(contador+2)
        //Añadir al contador
        contador = contador+1;
    }

   
});

function crearLinea(numero) {
    //Declaración de elementos basicos
    const iHabitacion = document.createElement('select');
    const br = document.createElement('br'); 
    //Agregar clases a la habitación
    iHabitacion.classList.add('EntradaTexto');
    iHabitacion.classList.add('Mitad');
    iHabitacion.classList.add('SHabitacion');
    //Agregar atributos a habitación
    iHabitacion.setAttribute("placeholder", "Habitación");
    iHabitacion.setAttribute("name", "Habitacion"+(numero));
   //Agregar SELECT TIPO
    const iTipo = document.createElement('select');
   //Clases SELECT TIPO
    iTipo.classList.add('EntradaTexto');
    iTipo.classList.add('Mitad');
    iTipo.classList.add('STipo');
   //Atributos SELECT TIPO
    iTipo.setAttribute("name", "Tipo"+(numero));
   //Agregar opciones tipo
   crearOpciones(tipos, iTipo);
   //Agregar opciones habitaciones
    var habitaciones;
    const xhttp2 = new XMLHttpRequest();
    xhttp2.open('GET', 'Normal.json', true);
    xhttp2.send();
    xhttp2.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            habitaciones = JSON.parse(this.responseText);
            crearOpciones(habitaciones, iHabitacion);
            //Agregar elementos
            contenedor.appendChild(iTipo);
            contenedor.appendChild(iHabitacion);
            contenedor.appendChild(br);
            STipos = document.querySelectorAll('.STipo');
            SHabitaciones = document.querySelectorAll('.SHabitacion');
            iTipo.addEventListener('change', cambiarOpciones);
        }
    }
   
}

function cambiarOpciones() {
    const SelectOpciones = this.nextSibling;
        for (let i = this.options.length; i >= 0; i--) {
            SelectOpciones.remove(i);
        }
    console.log(SelectOpciones);
    //AJAX
    const xhttp = new XMLHttpRequest();
    xhttp.open('GET', 'Otras.json', true);
    xhttp.send();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) { 
            const NuevasHabitaciones = JSON.parse(this.responseText);
            crearOpciones(NuevasHabitaciones, SelectOpciones);
        }
    }


}

function crearOpciones(Opciones, iSelect) {
    for (let index = 0; index < Opciones.length; index++) {
        const opcionHab = Opciones[index];
        //Crea la opcion
        const iOpcion = document.createElement('option');
        //Añade el valor de la opción
        
            iOpcion.setAttribute("value", opcionHab.tipo_ID);
        
        //Añade el texto a mostrar de la opcion
            var iOpcionTexto;
            if (opcionHab.tipo_Nombre == undefined) {
                iOpcionTexto = document.createTextNode(opcionHab.habitacion_Nombre);
            }
            else{
                iOpcionTexto = document.createTextNode(opcionHab.tipo_Nombre);
            }
            
            //Añade el texto de la opcion a la opcion
            iOpcion.appendChild(iOpcionTexto);
        
        //Añade la opción al SELECT Tipo
        iSelect.appendChild(iOpcion);   
    }
}

