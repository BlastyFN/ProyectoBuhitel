const verificar = document.querySelector('#BtnVerificar');
const contenedor = document.querySelector('#ContenedorInfo');
const campoHab = document.getElementById('Habitacion');
var vehiculo;
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
       var NodoBoton = document.createTextNode("Pedir");
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
        iBoton.setAttribute("id", "btnConfirmar");
        iBoton.appendChild(NodoBoton);
        iBoton.addEventListener('click', pedirServicio);
        iBoton.setAttribute("value", "1");
        //Integrar todo en tarjeta
        iTarjeta.appendChild(iTitulo);
        iTarjeta.appendChild(iInformacion);
        iTarjeta.appendChild(iBoton);
        return iTarjeta;
    }

}



verificar.addEventListener("click", function (e) {
    e.preventDefault();
    const infoHab = new FormData();
    infoHab.append('Habitacion', campoHab.value);
        fetch('../backend/consultarVehiculo.php', {
            method:'POST',
            body: infoHab
        })
        .then(function(response){
            if(response.ok) {
                return response.text();
            } else {
                throw "Error en la llamada Ajax";
            }
        })
        .then(function(texto) {
            if (texto == '0') {
                alert("No hay vehículos registrados");
                def();
            }
            else{
                var VehiculoInfoJS = JSON.parse(texto);
                // console.log(VehiculoInfoJS);
                const Tar = new TarjetaValet(campoHab.value, "Azul", VehiculoInfoJS.Huesped_Nombre, VehiculoInfoJS.Huesped_Apellidos, VehiculoInfoJS.Huesped_Contacto, VehiculoInfoJS.Vehiculo_Modelo, VehiculoInfoJS.Vehiculo_Placas);
                console.log(Tar);
                var TarjetaHTML = document.getElementById("TarVehiculo");
                vehiculo = Tar;
                contenedor.removeChild(TarjetaHTML);
                contenedor.appendChild(Tar.HTML);
            }
         })
         .catch(function(err) {
            console.log(err);
         });
});


function pedirServicio() {
    const botonFinal = document.getElementById('btnConfirmar');

    const infoVeh = new FormData();
    infoVeh.append('Placas', vehiculo.placas);

    infoVeh.append('Estatus', botonFinal.value);
        fetch('../backend/solicitudVehiculo.php', {
            method:'POST',
            body: infoVeh
        })
        .then(function(response){
            if(response.ok) {
                return response.text();
            } else {
                throw "Error en la llamada Ajax";
            }
        })
        .then(function(texto) {
            if (texto == '1') {
                if (botonFinal.value=='0') {
                    def();
                }
                else{
                    botonFinal.classList.remove('Verde');
                    botonFinal.classList.add('Naranja');
                    botonFinal.textContent = "Cancelar";
                    botonFinal.setAttribute("value", "0");
                }
                
            }
            else{
                alert("Error en el servidor");
            }
         })
         .catch(function(err) {
            console.log(err);
         });
}

function def() {
    const Tar = new TarjetaValet("Habitación", "Azul", "Nombre", "Apellidos", "Contacto", "Modelo", "Placas");
    console.log(Tar);
    vehiculo = Tar;
    var TarjetaHTML = document.getElementById("TarVehiculo");
    contenedor.removeChild(TarjetaHTML);
    contenedor.appendChild(Tar.HTML);   
}