const adicion = document.querySelector('#addImput'); //Obtiene el botón añadir
const contenedor = document.querySelector('#ContenedorEntradas');  //Obtiene el div en el que están las entradas
var categorias = document.getElementsByClassName('CatOriginal'); //Obtiene las opciones de categoria del PHP
var elementos = document.getElementsByClassName('EleOriginal'); //Obtiene las opciones de Elementos del PHP

//Contador de filas
var contador = 0;

//Evento de click en el botón Añadir
adicion.addEventListener("click", function(e){
    e.preventDefault();
    //Declaración de elementos basicos
    var iDiv = document.createElement('div');
    var iNum = document.createElement('input')
    var precio = document.createElement('h1');
    var br = document.createElement('br'); 
    //Agregar clase al div
    iDiv.classList.add('Entradas');
    //Agregar clases al input de numero
    iNum.classList.add('EntradaTexto');
    iNum.classList.add('Campo10');
    //Agregar atributos al input de numero
    iNum.setAttribute("type", "number");
    iNum.setAttribute("name", "CampoCantidad"+(contador+2));
    iNum.setAttribute("value", "1");
    iNum.setAttribute("min", "1");
    //Agregar texto al h1 (PROVISIONAL)
    var textoP = document.createTextNode("$0");
    precio.appendChild(textoP);

    //-------------SELECTS---------
    //SELECT CATEGORIA
    //Crear Select
    var iCategoria = document.createElement('select')
    //Agregar clases 
    iCategoria.classList.add('EntradaTexto');
    iCategoria.classList.add('Campo30');
    //Agregar atributos
    iCategoria.setAttribute("name", "categoria"+(contador+2));
    //Agregar opciones
    for (let index = 0; index < categorias.length; index++) {
        const opcionCPHP = categorias.item(index);
        //Crea la opcion
        const iOpcionCat = document.createElement('option');
        //Añade el valor de la opción
        if (opcionCPHP.getAttribute('value') != null) {
            iOpcionCat.setAttribute("value", opcionCPHP.getAttribute('value'));
        }
        //Añade el texto a mostrar de la opcion
        if (opcionCPHP.textContent != null) {
            const iOpcionCatTexto = document.createTextNode(opcionCPHP.textContent);
            //Añade el texto de la opcion a la opcion
            iOpcionCat.appendChild(iOpcionCatTexto);
        }
        //Añade la opción al SELECT Tipo
        iCategoria.appendChild(iOpcionCat);   
    }
    //SELECT ELEMENTO
    //Crear Select
    var iElemento = document.createElement('select')
    //Agregar clases 
    iElemento.classList.add('EntradaTexto');
    iElemento.classList.add('Campo30');
    //Agregar atributos
    iElemento.setAttribute("name", "elemento"+(contador+2));
    //Agregar opciones
    for (let index = 0; index < elementos.length; index++) {
        const opcionEPHP = elementos.item(index);
        //Crea la opcion
        const iOpcionEle = document.createElement('option');
        //Añade el valor de la opción
        if (opcionEPHP.getAttribute('value') != null) {
            iOpcionEle.setAttribute("value", opcionEPHP.getAttribute('value'));
        }
        //Añade el texto a mostrar de la opcion
        if (opcionEPHP.textContent != null) {
            const iOpcionEleTexto = document.createTextNode(opcionEPHP.textContent);
            //Añade el texto de la opcion a la opcion
            iOpcionEle.appendChild(iOpcionEleTexto);
        }
        //Añade la opción al SELECT Tipo
        iElemento.appendChild(iOpcionEle);   
    }
    //-------------SELECTS---------

    //Agregar elementos
    iDiv.appendChild(iCategoria);
    iDiv.appendChild(iElemento);
    iDiv.appendChild(iNum);
    iDiv.appendChild(precio);
    iDiv.appendChild(br);
    contenedor.appendChild(iDiv);

    //Añadir al contador
    contador = contador+1;
});