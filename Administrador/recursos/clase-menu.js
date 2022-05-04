const listaOpciones = ["Configuración de habitaciones", "Configuracion de usuarios", "Configuracion de servicios", "Reportes de usuarios","Reportes de análisis de sistemas","Modificar información general","Configuracion de chatbot"];
const listaLinks = ["item 1", "item 2", "item 3","item 1", "item 2", "item 3","item 1", "item 2", "item 3"];
var nombre = "Isaac";

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
        divBievenida.textContent = 'Hola de nuevo, ' + nombre;
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

        var contadorLinks = 0;
        listaOpciones.forEach((item) => {
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.textContent = item;
            a.setAttribute('href', listaLinks[contadorLinks]);
            contadorLinks++;
            li.appendChild(a);
            listaMenu.appendChild(li);
        });
        //Crear botón cerrar sesión
        const btnSalir = document.createElement('button');
        btnSalir.classList.add('btnSalir');
        btnSalir.setAttribute("onclick", "location.href ='http://google.com'");
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

const menu = new MenuLateral(listaOpciones,listaLinks);
menu.obtenerMenu();
