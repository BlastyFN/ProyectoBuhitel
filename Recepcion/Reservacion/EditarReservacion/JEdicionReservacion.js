const habitaciones = document.querySelector('#addHab'); //Obtiene el botón añadir
const contenedorHab = document.querySelector('#EntradasHab');  //Obtiene el div en el que están las entradas
const cargos = document.querySelector('#addCargo'); //Obtiene el botón añadir
const contenedorCar = document.querySelector('#EntradasCargo');  //Obtiene el div en el que están las entradas
//Contador de Habitaciones
var contador = 0;
//Evento de click en el botón Añadir Habitación
habitaciones.addEventListener("click", function(e){
    e.preventDefault();
    //Verifica el límite permitido de habitaciones por reservacion (5)
    if (contador<4) {
       //Declaración de elementos basicos
        const iHabitacion = document.createElement('input');
        const br = document.createElement('br'); 
        //Agregar clases a la habitación
        iHabitacion.classList.add('EntradaTexto');
        iHabitacion.classList.add('CampoCentrado');
        //Agregar atributos a habitación
        iHabitacion.setAttribute("placeholder", "Habitación");
        iHabitacion.setAttribute("name", "Habitacion"+(contador+2));

        //Agregar elementos
        contenedorHab.appendChild(br);
        contenedorHab.appendChild(iHabitacion);
        
        //Añadir al contador
        contador = contador+1;
        
    }
    
});

//Evento de click del botón Añadir Cargo
var contadorCargos = 0;
cargos.addEventListener("click", function(e){
    e.preventDefault();
    //Declaración de elementos básicos
    const iConcepto = document.createElement('input');
    const iMonto = document.createElement('input');
    const br = document.createElement('br');
    //Agregar clases al concepto
    iConcepto.classList.add('EntradaTexto');
    iConcepto.classList.add('TresCuartos');
    //Agregar atributos al concepto
    iConcepto.setAttribute("placeholder", "Concepto");
    iConcepto.setAttribute("name", "Concepto"+(contadorCargos+2));
    iConcepto.setAttribute("type", "Text")
    //Agregar clases al monto
    iMonto.classList.add('EntradaTexto');
    iMonto.classList.add('UnCuarto');
    //Agregar atributos al monto
    iMonto.setAttribute("placeholder", "$0");
    iMonto.setAttribute("name", "Monto"+(contadorCargos+2));
    iMonto.setAttribute("type", "Number")
    //Agregar elementos
    contenedorCar.appendChild(br);
    contenedorCar.appendChild(iConcepto);
    contenedorCar.appendChild(iMonto);
    contadorCargos = contadorCargos+1;
});