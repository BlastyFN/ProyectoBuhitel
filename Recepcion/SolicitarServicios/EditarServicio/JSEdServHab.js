const btnCambiarHab = document.getElementById('btnCambiar');
const campoHabCambio = document.getElementById('cmpHabCamb');
const textHabitacion = document.getElementById('textoHabitacion');
const textNombre = document.getElementById('TextoNombre');
const textApellidos = document.getElementById('TextoApellidos');
const textFecha = document.getElementById('TextoFecha');
const textPrecio = document.getElementById('TextoPrecio');
const contenedorEntradas = document.getElementById('ContenedorEntradas');
const adicion = document.querySelector('#addImput'); //Obtiene el botón añadir
const eliminacion = document.getElementById('popImput');
const btnCompletar = document.getElementById('btnCompletar');
var contador;
var EditableID;
var categorias;
var IDHabitacion;
var fase;
window.addEventListener('load', function () {
    contador = 0;
    setTimeout(function(){
        if (localStorage.EditarServicio == "true") {
            EditableID  = this.localStorage.IDServEd;
            campoHabCambio.value = localStorage.NombreHabEd;
            textHabitacion.innerHTML = this.localStorage.NombreHabEd;
            localStorage.EditarServicio = false;
            consultarInfoServicio(EditableID);
            cargarCategorias();
            consultarCarritos(EditableID);
            fase = 0;
        }
        else{
            alert("ERROR");
            window.location.href="http://corporativotdo.com/Recepcion/SolicitarServicios/ServiciosPrincipal/MenuServicios.php";
    
        }
    },5000);
    
    
});


campoHabCambio.addEventListener('keyup', function () {
   if (this.value != "") {
       btnCambiarHab.disabled = false;
   } 
   else{
       btnCambiarHab.disabled = true;
   }
});

function consultarInfoServicio(IDServicio) {
    const infoServicio = new FormData();
    infoServicio.append('Servicio', IDServicio);
    fetch('../backend/consultarInfoServicio.php', {
        method:'POST',
        body: infoServicio
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        if (texto != "x" && texto != "0") {
            var informacionServicio = JSON.parse(texto);
            console.log(informacionServicio);
            textNombre.innerHTML = informacionServicio.Huesped_Nombre;
            textApellidos.innerHTML = informacionServicio.Huesped_Apellidos;
            textFecha.innerHTML = informacionServicio.Servicio_Fecha;
            textPrecio.innerHTML = "Precio Total: $"+informacionServicio.Servicio_PrecioTotal;
        }
        else{
            alert("ERROR");
            console.log(texto);
        }
     })
     .catch(function(err) {
        console.log(err);
     });
}

function consultarCarritos(IDServicio) {
    const infoServicio = new FormData();
    infoServicio.append('Servicio', IDServicio);
    fetch('../backend/consultarCarritos.php', {
        method:'POST',
        body: infoServicio
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        if (texto != "x" && texto != "0") {
            var carritosServicio = JSON.parse(texto);
            console.log(carritosServicio);
            carritosServicio.forEach(element => {
                agregarFila();
            });
            var SelectsCategoria = document.querySelectorAll('.SCategoria');
            var SelectsProductos = document.querySelectorAll('.SProducto');
            SelectsCategoria.forEach( function(valor, indice, array) {
                valor.value = carritosServicio[indice].CatProd_ID;
                
                obtenerProductos(carritosServicio[indice].CatProd_ID, valor.nextSibling, valor.nextSibling.nextSibling, carritosServicio[indice].CarroProd_Producto, carritosServicio[indice].CarroProd_NumProductos);
                console.log("Terminado");
                const SelectProducto = valor.nextSibling;
                console.log(SelectProducto);
                asignarProductos();
            });
           
            // SelectsProductos.forEach( function(valor, indice, array) {
            //     console.log(valor.options);
            //     console.log(carritosServicio[indice].CarroProd_Producto);
            //     valor.value = carritosServicio[indice].CarroProd_Producto;


            // });
        }
        else{
            alert("ERROR");
            console.log(texto);
        }
     })
     .catch(function(err) {
        console.log(err);
     });
}

adicion.addEventListener('click', function () {
   agregarFila(); 
});


function agregarFila() {
    //Declaración de elementos basicos
    var iDiv = document.createElement('div');
    var iNum = document.createElement('input')
    var precio = document.createElement('h1');
    var iCheck = document.createElement('input');
    var br = document.createElement('br'); 
    //Agregar clase al div
    iDiv.classList.add('Entradas');
    iDiv.setAttribute('id', contador);
    //Agregar clases al input de numero
    iNum.classList.add('EntradaTexto');
    iNum.classList.add('Campo10');
    //Agregar atributos al input de numero
    iNum.setAttribute("type", "number");
    iNum.setAttribute("name", "CampoCantidad"+(contador+2));
    iNum.setAttribute("value", "1");
    iNum.setAttribute("min", "1");
    iNum.addEventListener("change", cambioNumero);
    //Agregar texto al h1 (PROVISIONAL)
    var textoP = document.createTextNode("$0");
    precio.appendChild(textoP);
    precio.classList.add("TPrecio");
    //AGREGAR INFO AL CHECKBOX
    iCheck.setAttribute("type", "checkbox");
    iCheck.setAttribute("id", contador);
    iCheck.classList.add("CheckBox");
    //-------------SELECTS---------
    //SELECT CATEGORIA
    //Crear Select
    var iCategoria = document.createElement('select')
    //Agregar clases 
    iCategoria.classList.add('EntradaTexto');
    iCategoria.classList.add('Campo30');
    iCategoria.classList.add('SCategoria')
    //Agregar atributos
    iCategoria.setAttribute("name", "categoria"+(contador+2));
    iCategoria.addEventListener('change', CambiarOpciones);
    //Agregar opciones
    crearOpciones(iCategoria, categorias);
    //SELECT ELEMENTO
    //Crear Select
    var iElemento = document.createElement('select')
    //Agregar clases 
    iElemento.classList.add('EntradaTexto');
    iElemento.classList.add('Campo30');
    iElemento.classList.add('SProducto');
    //Agregar atributos
    iElemento.setAttribute("name", "elemento"+(contador+2));
    iElemento.setAttribute("id", "elemento"+(contador+2));
    //Agregar opciones
    obtenerProductos(categorias[0].CatProd_ID, iElemento, iNum, "x", "x");
    iElemento.addEventListener('change', cambioElemento);
    //-------------SELECTS---------
    
    
    //Agregar elementos
    console.log(iCheck);
    iDiv.appendChild(iCheck);
    iDiv.appendChild(iCategoria);
    iDiv.appendChild(iElemento);
    iDiv.appendChild(iNum);
    iDiv.appendChild(precio);
    iDiv.appendChild(br);
    contenedorEntradas.appendChild(iDiv);

    //Añadir al contador
    contador = contador+1;
    
    var OpcionSeleccionada = iElemento.options;
}

eliminacion.addEventListener('click', function () {
    var Eliminables = document.querySelectorAll('.CheckBox');
    Eliminables.forEach(element => {
        if (element.checked == true) {
            console.log(element.id);
            console.log(element);
            console.log(element.parentElement);
            contenedorEntradas.removeChild(element.parentNode);
        }
    });
});

function cargarCategorias() {
    fetch('../backend/consultarCategorias.php', {
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
        console.log(texto);
        if (texto!="0") {
            categorias = JSON.parse(texto);
        }
        else{
            alert("NO HAY CATEGORIAS");
        }
     })
     .catch(function(err) {
        console.log(err);
     }); 
}

function crearOpciones(Select, ListaOpciones) {
    ListaOpciones.forEach(element => {
        const iOpcion = document.createElement('option');
        if (element.CatProd_ID!=undefined) {
            iOpcion.setAttribute("value", element.CatProd_ID);
            iOpcion.innerHTML=element.CatProd_Categoria;
        }
        else{
            iOpcion.setAttribute("id", element.Producto_ID);
            iOpcion.setAttribute("name", element.Producto_Precio);
            iOpcion.setAttribute("value", element.Producto_ID);
            iOpcion.innerHTML=element.Producto_Nombre;
            
        }
        Select.appendChild(iOpcion);
    });
}

function obtenerProductos(categoria, Select, Cantidad, valor, num) {
    console.log("Obteniendo Productos");    
    console.log(Select);
    console.log(valor);
    // Select.innerHTML ="";
    var productos;
    const infoCategoria = new FormData();
    infoCategoria.append('Categoria', categoria);
        fetch('../backend/consultarProductos.php', {
            method:'POST',
            body: infoCategoria
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
                alert("No hay productos registrados");
            }
            else{
                productos = JSON.parse(texto);
                while (Select.firstChild) {
                    console.log("Borrando " +Select.firstChild);
                    Select.remove(Select.firstChild);
                    
                }
                crearOpciones(Select, productos);
                if (valor != "x") {
                    Select.value = valor;
                    Cantidad.value = num;
                    actualizarPrecio(Cantidad, productos[Select.selectedIndex].Producto_Precio);
                }else{
                    if (valor =="x") {
                        actualizarPrecio(Cantidad, productos[0].Producto_Precio);
                    }
                    
                }
                
            }
         })
         .catch(function(err) {
            console.log(err);
         });
         return productos;
}

function CambiarOpciones() {

   
    obtenerProductos(this.value, this.nextSibling, this.nextSibling.nextSibling, "x", "x");
}

function asignarProductos() {
    console.log("ASIGNANDO PRODUCTOS");
}

function actualizarPrecio(Cantidad, PrecioUnitario) {
    if (fase!=0) {
        reiniciadorFase();
    }
    console.log("Actualizando");
    const TextoPrecio = Cantidad.nextSibling;
    // verificarFase();
    TextoPrecio.innerHTML = "$"+Cantidad.value *PrecioUnitario;
}

function cambioElemento() {
    
 
    var opcion = this.options.item(this.selectedIndex);
    precio = opcion.getAttribute("name");
    actualizarPrecio(this.nextSibling, precio);
}

function cambioNumero() {
    precio = this.nextSibling.innerHTML.slice(1);
    precio = precio/this.value;
    console.log();
    console.log(this.value);

    const SelectProd = this.previousSibling;
    var opcion = SelectProd.options.item(SelectProd.selectedIndex);
    precio = opcion.getAttribute("name");
    actualizarPrecio(this, precio);
}

btnCambiarHab.addEventListener("click", function () {
    const infoHabitacion = new FormData();
    infoHabitacion.append('Habitacion', campoHabCambio.value);
    fetch('../backend/consultarOcupacion.php', {
        method:'POST',
        body: infoHabitacion
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        if (texto != "x" && texto !="0") {
            var informacion = JSON.parse(texto);
            IDHabitacion = informacion.Habitacion_ID;
            btnCompletar.disabled= false;
            actualizarHabitacion(IDHabitacion);
        }
        else{
            btnCompletar.disabled= true;
            
            if (texto =="x") {
                alert("Error");
            }
            else{
                if (texto == "0") {
                    alert("Habitacion no válida");
                }
            }
        }
     })
     .catch(function(err) {
        console.log(err);
     }); 
});

function actualizarHabitacion(Habitacion) {
    const infoHabitacion = new FormData();
    infoHabitacion.append('Habitacion', Habitacion);
    infoHabitacion.append('Servicio', EditableID);
    fetch('../backend/actualizarHabitacionServicio.php', {
        method:'POST',
        body: infoHabitacion
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        if (texto != "x" && texto !="0") {
            alert("Habitacion actualizada");
            var infoNueva = JSON.parse(texto);
            console.log(infoNueva);
            textNombre.innerHTML = infoNueva.Huesped_Nombre;
            textApellidos.innerHTML = infoNueva.Huesped_Apellidos;
            textHabitacion.innerHTML = infoNueva.Habitacion_Nombre;
        }
        else{
            console.log(texto);
        }
     })
     .catch(function(err) {
        console.log(err);
     }); 
}

function reiniciadorFase() {
    console.log("Reiniciando");
    fase = 0;
    btnCompletar.innerHTML = "Verificar";
    btnCompletar.classList.remove("Verde");
    btnCompletar.classList.add("Naranja");
}

btnCompletar.addEventListener("click", function () {
    var precios = document.querySelectorAll(".TPrecio");
    var precioTotal= 0;
    precios.forEach(element => {
        console.log(element);
        var precio = element.innerHTML.slice(1);
        var numPrecio = parseInt(precio);
        precioTotal+=numPrecio;
    });
    
    switch (fase) {
        case 0:
            textPrecio.innerHTML = "Precio Total: $" + precioTotal; 
            btnCompletar.classList.remove("Naranja");
            btnCompletar.classList.add("Verde");
            btnCompletar.innerHTML = "Completar";
            fase = 1;
        break;
        
        case 1:
            completarActualizacion(precioTotal);
        break;
        default:
            break;
    }
});

function completarActualizacion(precio) {
    const infoServicioNuevo = new FormData();
    infoServicioNuevo.append('Servicio', EditableID);
    infoServicioNuevo.append('Precio', precio);
    fetch('../backend/actualizarServicio.php', {
        method:'POST',
        body: infoServicioNuevo
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        if (texto != "x" && texto !="0") {
            
            var Productos = document.querySelectorAll(".SProducto");
                Productos.forEach(element => {
                    var ProdID = element.value;
                    var Cant = element.nextSibling.value;
                    ordenarCarrito(EditableID, ProdID, Cant);
                });
            alert(texto);
            window.location.href="http://corporativotdo.com/Recepcion/SolicitarServicios/ServiciosPrincipal/MenuServicios.php";
        }
        else{
            console.log(texto);
        }
     })
     .catch(function(err) {
        console.log(err);
     }); 
}

function ordenarCarrito(Servicio, Producto, Cantidad) {
    const infoCarrito = new FormData();
            infoCarrito.append('Servicio', Servicio);
            infoCarrito.append('Producto', Producto);
            infoCarrito.append('Cantidad', Cantidad);
            fetch('../backend/registrarCarrito.php', {
                method:'POST',
                body: infoCarrito
            })
            .then(function(response){
                if(response.ok) {
                    return response.text();
                } else {
                    throw "Error en la llamada Ajax";
                }
            })
            .then(function(texto) {
                console.log(texto);
            })
            .catch(function(err) {
                console.log(err);
            });
}