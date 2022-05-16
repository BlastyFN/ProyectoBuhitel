const listaTitulos = ["titulo 1", "titulo 2", "titulo 3"];
const listaContenidos = ["item 1", "item 2", "item 3"];

class Tarjeta{
    constructor(titulo,contenido){
        this.titulo = titulo;
        this.contenido = contenido;
    }

    get Card(){
        return this.obtenerTarjeta();
    }

    obtenerTarjeta(){
      
        
        const contCards = document.querySelector(".containCards");
        const fragment = document.createDocumentFragment();
        var numCards = 0;
        listaTitulos.forEach((item) => {
            //Crear contenedor de tarjeta
            const contIndividual = document.createElement('div'); 
            contIndividual.classList.add("contIndividual");
            //Crear titulo de tarjeta
            const tituloTarjeta = document.createElement('div');
            tituloTarjeta.classList.add("cardBoard");
            tituloTarjeta.textContent = item;

            const contenidoTarjeta = document.createElement('div');
            contenidoTarjeta.classList.add("card");
            contenidoTarjeta.textContent = listaContenidos[numCards];
            numCards++;

            contIndividual.appendChild(tituloTarjeta);
            contIndividual.appendChild(contenidoTarjeta);
            fragment.appendChild(contIndividual);
        });

        

        contCards.appendChild(fragment);
        console.log(contCards);
        
    }
}
/*
            <div class="contIndividual" >
                <div class="cardBoard">Titulo tarjeta 1</div>
                <div class="card">Contenido tarjeta 1</div>
            </div>
*/
const tarjetas = new Tarjeta(listaOpciones,listaLinks);
tarjetas.obtenerTarjeta();