var listaOpciones = [];
var listaLinks = [];

const opcionesAdministrador = ["Pagina Principal", "Configuración de habitaciones","Configuracion de usuarios",
    "Configuracion de servicios", "Reportes de usuarios","Reportes de análisis de sistemas",
    "Modificar información general","Configuracion de chatbot"]
const linksAdministrador = ["Administrador/pagina principal admin/pagPrincipalAdmin.php",
 "Administrador/moduloHabitaciones/VistaGeneralHab/vistaGeneralHab.php", 
 "Administrador/moduloPersonal/vistaGeneralUsuarios/vistaGeneralUsuarios.php", 
 "Administrador/moduloServicios/vistaGeneralServicios/vistaGeneralServicios.php","Link Reportes de usuarios", 
 "Link Reportes sistema", "link modificar info general","link configuración chatbot"];

const opcionesRecepcion = ["Pagina Principal", "Consultar Reservaciones","Crear Reservaciones",
    "Consultar servicios", "Servicios de limpieza","Servicio a habitación","Servicio de valet parking"];
const linksRecepcion = ["Administrador/pagina principal admin/pagPrincipalAdmin.html", 
    "Recepcion/Reservacion/ConsultarReservaciones/ConsultaReservaciones.php", 
    "Recepcion/Reservacion/CrearReservacion/Reservacion.php", 
    "Recepcion/SolicitarServicios/ServiciosPrincipal/MenuServicios.php",
    "Recepcion/SolicitarServicios/SolicitarLimpieza/SolLimpieza.php", 
    "Recepcion/SolicitarServicios/SolicitarServicio/SolServHab.php", 
    "Recepcion/SolicitarServicios/SolicitarValet/SolValet.php"];

const opcionesValet = ["Gestionar Vehículos","Visualizar Vehículos"];
const linksValet = ["ValetParking/Vehiculos/GestionarVehículos"];

class MenuLateral{
    constructor(opciones, links){
        this.opciones = opciones;
        this.links = links;
    }

    get Menu(){
        return this.obtenerMenu();
    }

    obtenerMenu(){
      
        
        const headerMenu = document.getElementById('header-menu');
        const fragment = document.createDocumentFragment();

        //Crear header
        const header = document.createElement('header'); 
        header.classList.add("containHeader");
        //Crear img para logo
        const imgLogo = document.createElement("img"); 
        imgLogo.classList.add("logo");
        imgLogo.setAttribute('src','../../../imagenes/buhitel-logo.png');
        imgLogo.setAttribute('alt','logo buhitel');
        //Crear bienvenida
        const divBievenida = document.createElement('div');
        divBievenida.setAttribute('id', 'bienvenida');
        divBievenida.textContent = 'Hola de nuevo, ' + localStorage.Nombre;
        //agregar a header
        header.appendChild(imgLogo);
        header.appendChild(divBievenida);
        fragment.appendChild(header);
    
        //Crear sección de menú
        const containMenu = document.createElement('section');
        containMenu.classList.add('containMenu');
        //Crear div del sideBar
        const sideBar = document.createElement('div');
        sideBar.setAttribute('id', 'sidebar');
        sideBar.classList.add('active');
        //Crear div toggle btn
        const toggleBtn = document.createElement('div');
        toggleBtn.classList.add('toggle-btn');
        toggleBtn.setAttribute('id','btn');
        //Crear span
        const icono = document.createElement('span');
        icono.textContent = '=';
        //Agregar span a div toggle btn
        
        //Crear lista 
        const listaMenu = document.createElement('ul');
        listaMenu.setAttribute('id','listaMenu');
        //Crear elementos de la lista
        var URL = "https://corporativotdo.com/";
        var contadorLinks = 0;

        if (localStorage.Tipo == "Administrador"){
            listaOpciones = opcionesAdministrador;
            listaLinks = linksAdministrador; 
        } else if (localStorage.Tipo == "Recepcion"){
            listaOpciones = opcionesRecepcion;
            listaLinks = linksRecepcion;
        } else if (localStorage.Tipo == "Valet"){
            listaOpciones = opcionesValet;
            listaLinks = linksValet;
        }

        listaOpciones.forEach((item) => {
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.textContent = item;
            a.setAttribute('href', URL + listaLinks[contadorLinks]);
            contadorLinks++;
            li.appendChild(a);
            listaMenu.appendChild(li);
        });
        //Crear botón cerrar sesión
        const btnSalir = document.createElement('button');
        btnSalir.classList.add('btnSalir');
        
        btnSalir.addEventListener("click", cerrarSesion);
        btnSalir.textContent = "Cerrar Sesión";


        
        toggleBtn.appendChild(icono);
        sideBar.appendChild(toggleBtn);
        sideBar.appendChild(listaMenu);
        sideBar.appendChild(btnSalir);
        containMenu.appendChild(sideBar);
        fragment.appendChild(containMenu);
        headerMenu.appendChild(fragment);
        
    }
}

function cerrarSesion() {
    fetch('../../../Recursos/cerrarSesion.php', {
        method:'POST'
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        alert(texto);
        console.log(texto);
        localStorage.clear();
        setTimeout(function () {   
            window.location.replace("https://corporativotdo.com/");
        }, 1000);
     })
     .catch(function(err) {
        console.log(err);
     });
}

const menu = new MenuLateral(listaOpciones,listaLinks);
menu.obtenerMenu();
