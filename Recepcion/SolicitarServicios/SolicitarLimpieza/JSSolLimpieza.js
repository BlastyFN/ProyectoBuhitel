const verificar = document.querySelector('#BtnVerificar');
const contenedor = document.querySelector('#ContenedorInfo');
class TarjetaLimpieza {
    constructor(habitacion, color, nombre, apellidos, inicio, fin){
        this.habitacion = habitacion;
        this.color = color;
        this.nombre = nombre;
        this.apellidos = apellidos;
        this.inicio = inicio;
        this.fin = fin;
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
       var NodoBoton = document.createTextNode("Completar");
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
        iBoton.classList.add('Verde');
        iBoton.classList.add('ModelBtn');
        iBoton.classList.add('Ult');
        iBoton.appendChild(NodoBoton);
        //Integrar todo en tarjeta
        iTarjeta.appendChild(iTitulo);
        iTarjeta.appendChild(iInformacion);
        iTarjeta.appendChild(iBoton);
        return iTarjeta;
    }
}
verificar.addEventListener("click", function (e) {
    e.preventDefault();
    const Tar = new TarjetaLimpieza("9", "Azul", "Alfonso", "Petersen Nuñez", "12:12", "13:12");
    
    var TarjetaHTML = document.getElementById("TarLimpieza");
    contenedor.removeChild(TarjetaHTML);
    console.log(Tar.HTML);
    contenedor.appendChild(Tar.HTML);
});

