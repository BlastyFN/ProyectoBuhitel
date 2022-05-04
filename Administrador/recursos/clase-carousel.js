const pisos = [1];
const numHabs = [101,202,303,104,105,106,107,108,109];

class Carousel {

    constructor(piso, numHabs){
        this.piso = pisos;
        this.numHabs = numHabs
    }

    getCarousel(){
        return this.obtenerCarousel();
    }

//         <section class="piso">
//         <div class="nombrePiso">Piso 1</div> 
//         <div class="carousel">

    obtenerCarousel(){
        pisos.forEach((itemPisos) => {
            const contCards = document.getElementById('contenedorVistaHabs');
            const fragment = document.createDocumentFragment();
            const allCarousel = document.createElement('div');

            allCarousel.classList.add('carouselCompleto');
            //Se crea la sección piso
            const sectionPiso = document.createElement('section');
            sectionPiso.classList.add('piso');
            //Se crea el div nombrePiso
            const divNombrePiso = document.createElement('div')
            divNombrePiso.classList.add('nombrePiso');
            divNombrePiso.textContent = "Piso " + itemPisos;
            sectionPiso.appendChild(divNombrePiso);
            //Se crea el div carousel
            const divCarousel = document.createElement('div');
            divCarousel.classList.add('carousel');
            //Se crea el div carousel__contenedor
            const divCarouselContenedor = document.createElement('div');
            divCarouselContenedor.classList.add('carousel__contenedor');
            //Se crea el botón anterior
            const buttonAnterior = document.createElement('button');
            buttonAnterior.setAttribute("aria-label","Anterior");
            buttonAnterior.classList.add("carousel__anterior");
            //Se crea el i span
            const iconoFlechaAnterior = document.createElement('i');
            iconoFlechaAnterior.classList.add('fas','fa-chevron-left');
            //Se agrega el icono al botón

            buttonAnterior.appendChild(iconoFlechaAnterior);
            divCarouselContenedor.appendChild(buttonAnterior);

            //Se crea el div carousel__lista
            const divCarouselLista = document.createElement('div');
            divCarouselLista.classList.add('carousel__lista','glider');
            
            numHabs.forEach((item) => {
                const divCarouselElemento = document.createElement('div');
                divCarouselElemento.classList.add('carousel__elemento');
                const saltoLinea = document.createElement('br');
                divCarouselElemento.textContent = "Habitación" + item + " doble";
                divCarouselLista.appendChild(divCarouselElemento);            
            
            })

            //Se agrega la lista de habs al contenedor del carousel
            divCarouselContenedor.appendChild(divCarouselLista);

            //Se crea el botón siguiente
            const buttonSiguiente = document.createElement('button');
            buttonSiguiente.setAttribute("aria-label","Siguiente");
            buttonSiguiente.classList.add("carousel__siguiente");
            //Se crea el i span
            const iconoFlechaSiguiente = document.createElement('i');
            iconoFlechaSiguiente.classList.add('fas','fa-chevron-right');
            //Se agrega el icono al botón
        
            buttonSiguiente.appendChild(iconoFlechaSiguiente);
            divCarouselContenedor.appendChild(buttonSiguiente);
            divCarousel.appendChild(divCarouselContenedor);
            sectionPiso.appendChild(divCarousel); //Section piso queda completo


            //Crear el div de indicadores
            const divIndicadores = document.createElement('div');
            divIndicadores.setAttribute("role","tablist");
            divIndicadores.classList.add("carousel__indicadores",'glider-dots');

            allCarousel.appendChild(sectionPiso);
            allCarousel.appendChild(divIndicadores);
            fragment.appendChild(allCarousel);
            contCards.appendChild(fragment);
            console.log(allCarousel);
    })

//     <div role="tablist" class="carousel__indicadores"></div> 
    //div
//        <section class="piso">
//         <div class="nombrePiso">Piso 1</div> 
//         <div class="carousel">
//             <div class="carousel__contenedor">
//                 <button aria-label="Anterior" class="carousel__anterior">
//                     <i class="fas fa-chevron-left"></i> //////// ya
//                 </button>
//                 <div class="carousel__lista">

//                     <div class="carousel__elemento">
//                         Habitación 1 <br> Doble            
//                     </div>

//                     <div class="carousel__elemento">
//                         Habitacion 2 <br> individual
//                     </div>

//                     <div class="carousel__elemento">
//                         Habitación 1 <br> Doble            
//                     </div>
//                     <div class="carousel__elemento">
//                         Habitacion 2 <br> individual
//                     </div>


//                     <div class="carousel__elemento">
//                         Habitación 1 <br> Doble            
//                     </div>
//                     <div class="carousel__elemento">
//                         Habitacion 2 <br> individual
//                     </div>


//                     <div class="carousel__elemento">
//                         Habitación 1 <br> Doble            
//                     </div>
//                     <div class="carousel__elemento">
//                         Habitacion 2 <br> individual
//                     </div>


//                 </div>            
//                 <button aria-label="Siguiente" class="carousel__siguiente">
//                     <i class="fas fa-chevron-right"></i>
//                 </button>
//             </div>
//     </section>
//     <div role="tablist" class="carousel__indicadores"></div>     
// div

    }
}

const carouselHabs = new Carousel(pisos, numHabs);
carouselHabs.getCarousel();