var pisos = new Array();
const carouselesHab = document.querySelector(".vistaHabs");
const popup = document.querySelector('.popup');
const overlay = document.querySelector('.overlay');
const btnCerrarPopup = document.querySelector('.cerrarPopup');
const opciones = document.getElementById('opcDesplegable');
const nombreHab = document.querySelector('.nombreHab');
const precioNoche = document.querySelector('.precioNoche');
const numCamas = document.querySelector('.numCamas');
const limpiezaNormal = document.querySelector('.limpiezaNormal');
const limpiezaProfunda = document.querySelector('.limpiezaProfunda');
const btnBuscar = document.querySelector('.searchButton');
const busqueda = document.querySelector('.searchElement');
const contenedorPisos = document.querySelector('.vistaHabs');
const btnDesactivar = document.querySelector('.desactivar');
const btnGuardar = document.querySelector('.guardar');
var tiposHabs;
const fragment = document.createDocumentFragment();

var habID;
var habSeleccionada;


class Piso{
    constructor(pisoID, pisoNum, habs){
        this.pisoID = pisoID;
        this.pisoNum = pisoNum;
        this.habs = habs;
    }

    get HTML(){
        return this.obtenerHTML();
    }

    obtenerHTML(){
            
        const fragment = document.createDocumentFragment();
        
        const numeroPiso = document.createElement('h3');
        numeroPiso.textContent = "Piso " + this.pisoNum;
        fragment.appendChild(numeroPiso);

        const divCarousel = document.createElement('div');
        divCarousel.classList.add("owl-carousel","owl-theme","owl-loaded", "owl-drag");
        
        var habitaciones = this.habs;
        console.log(habitaciones);
                
        for(var contHabs = 0; contHabs < habitaciones.length;contHabs++){ 
            console.log(habitaciones[contHabs].habNombre);
            console.log(habitaciones[contHabs].habTipoNombre);
            if(busqueda.value == ""){
                divCarousel.appendChild(habitaciones[contHabs].HTML);
            }   
            else if(habitaciones[contHabs].habNombre.includes(busqueda.value) || 
               habitaciones[contHabs].habTipoNombre.includes(busqueda.value)){   

                divCarousel.appendChild(habitaciones[contHabs].HTML);
            }
        }   
        fragment.appendChild(divCarousel);
                    
        return fragment;
    }


}

class Habitacion {
    constructor(habID,habNombre, habTipo, habTipoNombre){
        this.habID = habID;
        this.habNombre = habNombre;
        this.habTipo = habTipo;
        this.habTipoNombre = habTipoNombre;
    }
    get HTML(){
        return this.obtenerHTML();
    }

    obtenerHTML(){
        
        const divHab = document.createElement('div');
        divHab.classList.add("item","carousel-elemento");
        divHab.setAttribute("id",this.habID);
        const nombreHab = document.createElement('h4');
        nombreHab.classList.add('inside-item');
        nombreHab.textContent = "Habitación " + this.habNombre;
        divHab.appendChild(nombreHab);

        const tipoHab = document.createElement('h4');
        tipoHab.classList.add('inside-item');
        tipoHab.textContent = this.habTipoNombre;
        divHab.appendChild(tipoHab);


        
            
        return divHab;
    }
}

function cargarOpcionesTiposHab(){


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
            tiposHabs = texto;
            var inputTipoHab = document.createElement('option');
            inputTipoHab.classList.add('opcTipoHab');
            inputTipoHab.setAttribute('value',element.tipohab_ID);
            inputTipoHab.textContent = element.tipohab_nombre;
            console.log(inputTipoHab.value);
            fragment.appendChild(inputTipoHab);
            
        }
        
        opciones.appendChild(fragment);
        //cargarInfoTipoHab(opciones.value);
    });
}

opciones.addEventListener('change', (e)=>{
    e.preventDefault();

    for (const tipoHab of tiposHabs) {
        if(tipoHab.tipohab_ID == opciones.value){
            precioNoche.textContent = "Precio por noche: $" + tipoHab.TipoHab_Precio;
            numCamas.textContent = "Número de camas: " + tipoHab.TipoHab_NumCamas;
            limpiezaNormal.textContent = "Tiempo de limpieza normal"+  tipoHab.TipoHab_TiempoLimpNormal;
            limpiezaProfunda.textContent = "Tiempo de limpieza profunda " + tipoHab.TipoHab_TiempoLimpProfunda;
        }
    }
    
})

btnDesactivar.addEventListener('click', ()=>{
    hab = obtenerObjetoHab(habID);
    hab.habitcion_estado = !hab.habitacion_estado;
    if(hab.habitacion_estado == true){
        btnDesactivar.textContent = "Deshabilitar";
    } 
    else{
        btnDesactivar.textContent = "Habilitar";
    }
})

btnGuardar.addEventListener('click', (e)=>{
    e.preventDefault();
    const modificarHabTipo = new FormData();
    modificarHabTipo.append("habID",number(habID));
    modificarHabTipo.append("tipoID",number(opciones.value))
    
    fetch('../backend/cambiarHabTipo.php' , {
        method:'POST',body:modificarHabTipo
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(texto){
 
    });
})

document.addEventListener('DOMContentLoaded', () => {
    obtenerPisosHotel().then(
        carouselesHab.addEventListener('click', e =>{
            seleccionarHab(e);

        })
        

    );
});

btnBuscar.addEventListener('click', (e)=>{
    e.preventDefault();
    for (piso of pisos) {
        contenedorPisos.innerHTML="";
        contenedorPisos.appendChild(piso.HTML);
    }
    

})


const seleccionarHab = e =>{
    if(e.target.classList.contains('inside-item')){
        e.stopPropagation();
        console.log(e.target.parentElement.id);
        habID = e.target.parentElement.id;
        var hab = obtenerObjetoHab(habID);
        console.log(hab);
        if(hab.habitacion_estado == true){
            btnDesactivar.textContent = "Deshabilitar";
        } 
        else{
            btnDesactivar.textContent = "Habilitar";
        }
        overlay.classList.add('active');
        popup.classList.add('active');
        cargarOpcionesTiposHab();
        
    }
};    

btnCerrarPopup.addEventListener('click', e =>{
    overlay.classList.remove('active');
    popup.classList.remove('active');
    let inputs = Array.prototype.slice.call(document.getElementsByClassName("opcTipoHab"), 0);
    console.log(inputs);
    for(element of inputs){
        element.remove();
      } 
}) 



function obtenerPisosHotel(){
  return new Promise((resolve,reject)=>{
   
    fetch("../backend/obtenerPisos.php", {
        method:'POST'
    }).then(function(response){
        if(response.ok){
            return response.json();
            } else {
               throw "Error en la llamada Ajax"
            }      
    }).then(function(res){  
        var contadorPisos  = 1;
        for(element of res){                       
            obtenerHabs(element.piso_ID,contadorPisos).then((nPiso) =>{               
                console.log(nPiso);
                pisos.push(nPiso);
                contenedorPisos.appendChild(nPiso.HTML);
                console.log(nPiso.HTML);

                var owl = $('.owl-carousel');
                owl.owlCarousel({
                    loop:false,
                    nav:true,
                    margin:10,
                    responsive:{
                        0:{
                            items:1
                        },
                        600:{
                            items:3
                        },            
                        960:{
                            items:5
                        },
                        1200:{
                            items:6
                        }
                    }
                });  
            });
            contadorPisos++;          
        }        
    });
    resolve(); 
  });  
   
}



function obtenerHabs(pisoID, numPiso){
    return new Promise((resolve,reject) => {
        var resuArray = [];
        const solicitarNumHabs = new FormData();
        solicitarNumHabs.append("piso",pisoID);
        fetch("../backend/obtenerHabsPorPiso.php", {
            method:'POST', body: solicitarNumHabs
        }).then(function(response){
            if(response.ok){               
                return response.text();                
            } else {
                throw "Error en la llamada Ajax"
            }      
        }).then(function(resHabs){
            //console.log(resHabs);
            var jsonHabs = JSON.parse(resHabs);
            for(element of jsonHabs){
                nuevaHab = new Habitacion(element.habitacion_ID,element.habitacion_nombre,
                    element.habitacion_tipo, element.TipoHab_Nombre);
                resuArray.push(nuevaHab);
                
            }
            const nuevoPiso = new Piso(pisoID, numPiso, resuArray);
            resolve(nuevoPiso);
        });
    });    
}


function obtenerObjetoHab(id){
    for (piso of pisos) {
        for (hab of piso.habs) {
            if (hab.habID == id) return hab;
        }
    }
}

