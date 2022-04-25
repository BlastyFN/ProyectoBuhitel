const ContenedorPrincipal = document.getElementById('ContenedorPrincipal');
class Servicio {
    constructor(Nombre, Apellidos, Modelo, Color, Placas, Lugar, Notas){
        this.Nombre = Nombre;
        this.Apellidos = Apellidos;
        this.Modelo = Modelo;
        this.Color = Color;
        this.Placas = Placas;
        this.Lugar = Lugar;
        this.Notas = Notas;
    }

    get HTML(){
        return this.obtenerHTML();
    }

    obtenerHTML(){
            var ContenedorServicio = document.createElement('section');
            ContenedorServicio.classList.add('ContenedorInfo');
            //TITULOS
            var ContenedorTitulos = document.createElement('div');
            var SubContenedorInfo = document.createElement('div');
            var SubContenedorNotas = document.createElement('div');
            //CLASES TITULOS
            ContenedorTitulos.classList.add('Titulos');
            ContenedorTitulos.classList.add('Contenedor');
            ContenedorTitulos.classList.add('Azul');
            SubContenedorInfo.classList.add('Info');
            SubContenedorNotas.classList.add('Notas');
            //CONTENIDO TITULOS
            var TextoServicio = document.createElement('h3');
            var TextoNotas = document.createElement('h3');
            //CLASES Y PROPIEDADES CONTENIDO TITULOS
            TextoServicio.classList.add('TBlanco');
            TextoNotas.classList.add('TBlanco');
            TextoServicio.classList.add('CentrarTexto');
            TextoNotas.classList.add('CentrarTexto');
            //CONTENIDO TEXTOS
            TextoServicio.appendChild(document.createTextNode('Servicio Solicitado'));
            TextoNotas.appendChild(document.createTextNode('Notas'));
            //APPENDS TITULOS
            SubContenedorInfo.appendChild(TextoServicio);
            SubContenedorNotas.appendChild(TextoNotas);
            ContenedorTitulos.appendChild(SubContenedorInfo);
            ContenedorTitulos.appendChild(SubContenedorNotas);
            ContenedorServicio.appendChild(ContenedorTitulos);
            //INFORMACION
            var ContenedorDatos = document.createElement('div');
            var SubContenedorDatos = document.createElement('div');
            var SubContenedorDatosNotas = document.createElement('div');
            //CLASES CONTENEDORES
            ContenedorDatos.classList.add('Contenido');
            ContenedorDatos.classList.add('Contenedor');
            SubContenedorDatos.classList.add('Info');
            SubContenedorDatosNotas.classList.add('Notas');
            //DATOS Y NOTAS
            var DatoNombre = document.createElement('h1');
            var DatoApellidos = document.createElement('h1');
            var DatoModelo = document.createElement('h1');
            var DatoColor = document.createElement('h1');
            var DatoPlacas =document.createElement('h1');
            var DatoLugar =document.createElement('h1');
            var DatoNotas = document.createElement('p');
            //CLASES DATOS Y NOTAS
            DatoNombre.classList.add('Dato');
            DatoApellidos.classList.add('Dato');
            DatoModelo.classList.add('Dato');
            DatoColor.classList.add('Dato');
            DatoPlacas.classList.add('Dato');
            DatoLugar.classList.add('Dato');
            DatoNotas.classList.add('Dato');
            //TEXTOS DATOS Y NOTAS
            DatoNombre.appendChild(document.createTextNode('Nombre: '+this.Nombre));
            DatoApellidos.appendChild(document.createTextNode('Apellidos: '+this.Apellidos));
            DatoModelo.appendChild(document.createTextNode('Modelo: ' +this.Modelo));
            DatoColor.appendChild(document.createTextNode('Color: '+this.Color));
            DatoPlacas.appendChild(document.createTextNode('Placas: '+this.Placas));
            DatoLugar.appendChild(document.createTextNode('Lugar: '+this.Lugar));
            DatoNotas.appendChild(document.createTextNode(this.Notas));
            //APPENDS  DATOS Y NOTAS
            SubContenedorDatos.appendChild(this.obtenerBR());
            SubContenedorDatos.appendChild(DatoNombre);
            SubContenedorDatos.appendChild(DatoApellidos);
            SubContenedorDatos.appendChild(DatoModelo);
            SubContenedorDatos.appendChild(DatoColor);
            SubContenedorDatos.appendChild(DatoLugar);
            SubContenedorDatos.appendChild(DatoPlacas);
            SubContenedorDatos.appendChild(this.obtenerBR());
            SubContenedorDatosNotas.appendChild(this.obtenerBR());
            SubContenedorDatosNotas.appendChild(DatoNotas);
            SubContenedorDatosNotas.appendChild(this.obtenerBR());
            ContenedorDatos.appendChild(SubContenedorDatos);
            ContenedorDatos.appendChild(SubContenedorDatosNotas);
            ContenedorServicio.appendChild(ContenedorDatos);
            //BOTON
            var iBoton = document.createElement('button');
            var textoBoton = document.createElement('h3');
            //CLASES Y PROPIEDADES BOTON
            iBoton.classList.add('Verde');
            iBoton.classList.add('BtonModel');
            iBoton.setAttribute('value', this.Placas);
            iBoton.addEventListener('click', completarServicio);
            //TEXTO BOTON
            textoBoton.appendChild(document.createTextNode('Completar'));
            iBoton.appendChild(textoBoton);
            ContenedorServicio.appendChild(iBoton);
            ContenedorServicio.appendChild(this.obtenerBR());
            ContenedorServicio.appendChild(this.obtenerBR());
            return ContenedorServicio;

    }

    obtenerBR(){
        var SL = document.createElement('br');
        return SL;
    }
}

window.addEventListener('load', obtenerServicios);

function obtenerServicios() {
    while (ContenedorPrincipal.firstChild) {
        ContenedorPrincipal.removeChild(ContenedorPrincipal.firstChild);
    }
        fetch('../backend/consultarServicios.php', {
            method:'POST',
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
                alert("No se encontraron servicios");

            }
            else{
                var infoServicios = JSON.parse(texto);
                console.log(infoServicios);
                desplegar(infoServicios);
            }
         })
         .catch(function(err) {
            console.log(err);
         });
}

function desplegar(ListaServicios) {
    ListaServicios.forEach(element => {
        var Ser = new Servicio(element.Huesped_Nombre, element.Huesped_Apellidos, element.Vehiculo_Modelo, element.Vehiculo_Color, element.Vehiculo_Placas, element.Vehiculo_LugarEstacionamiento, element.Vehiculo_Notas);
        console.log(Ser.HTML);
        ContenedorPrincipal.appendChild(Ser.HTML);
    });
}

function completarServicio() {
    const datoPlacas = new FormData();
    datoPlacas.append('Placas', this.value);
    fetch('../backend/completarServicio.php', {
        method:'POST',
        body: datoPlacas
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
            obtenerServicios();
        }
        else{

        }
     })
     .catch(function(err) {
        console.log(err);
     });
}