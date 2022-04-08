const verificar = document.querySelector('#BtnVerificar');
const contenedor = document.querySelector('#ContenedorInfo');
class TarjetaValet {
    constructor(habitacion, color, nombre, apellidos, contacto, modelo, placas){
        this.habitacion = habitacion;
        this.color = color;
        this.nombre = nombre;
        this.apellidos = apellidos;
        this.contacto = contacto;
        this.modelo = modelo;
        this.placas = placas;
    }
    get HTML() {
        return this.obtenerHTML();
    }
    obtenerHTML(){
       //NODOS DE TEXTO
       var NodoBoton = document.createTextNode("Completar");
       var NodoTitulo = document.createTextNode(this.habitacion);
       var NodoNombre = document.createTextNode(this.nombre);
       var NodoApellidos = document.createTextNode(this.apellidos);
       var NodoContacto = document.createTextNode(this.contacto);
       var NodoModelo = document.createTextNode(this.modelo);
       var NodoPlacas = document.createTextNode(this.placas);
       
        //Div general
        var iTarjeta = document.createElement('div');
        iTarjeta.classList.add('Tarjeta');
        iTarjeta.classList.add(this.color);
        iTarjeta.setAttribute("id", "TarVehiculo");
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
        var iContacto = document.createElement('p');
        iContacto.appendChild(NodoContacto);
        var iModelo = document.createElement('p');
        iModelo.appendChild(NodoModelo);
        var iPlacas = document.createElement('p');
        iPlacas.appendChild(NodoPlacas);
        iInformacion.appendChild(iNombre);
        iInformacion.appendChild(iApellidos);
        iInformacion.appendChild(iContacto);
        iInformacion.appendChild(iModelo);
        iInformacion.appendChild(iPlacas);
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
    const xhttp = new XMLHttpRequest();
    xhttp.open('GET', 'Servicio.json', true);
    xhttp.send();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let datos = JSON.parse(this.responseText);
            const Tar = new TarjetaValet(datos.habitacion_Nombre, "Azul", datos.huesped_Nombre, datos.huesped_Apellidos, datos.huesped_Contacto, datos.vehiculo_Modelo, datos.vehiculo_Placas);
            console.log(Tar.HTML);
            var TarjetaHTML = document.getElementById("TarVehiculo");
            contenedor.removeChild(TarjetaHTML);
            contenedor.appendChild(Tar.HTML);
        }
    }
});

