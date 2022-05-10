const adicion = document.querySelector('#addImput'); //Obtiene el botón añadir
const verificar = document.getElementById('btnVerificar');
const campoHab = document.getElementById('cmpVerificar');
const contenedorPrincipal = document.getElementById('SeccionTotal');
const contenedorEntradas = document.getElementById('ContenedorEntradas');
const Tarjeta = document.getElementById('TarServ');
const TarHabitacion = document.getElementById('textoHabitacion');
const TarNombre = document.getElementById('TextoNombre');
const TarApellidos = document.getElementById('TextoApellidos');
const TarCantidad = document.getElementById('TextoCantidad');
const TarPrecio = document.getElementById('TextoPrecio');
const btnCompletar = document.getElementById('btnCompletar');
var IDHabitacion;
var IDServicio;
var categorias;
var fase;
var PTOTAL;

//Contador de filas
var contador = 0;
window.addEventListener("load", function() {
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
});
//Evento de click en el botón Añadir
adicion.addEventListener("click", function(e){
    e.preventDefault();
    agregarFila();
    if (contador>0) {
        btnCompletar.disabled = false;
        verificarFase();
        fase = 0;
    }
    
});

campoHab.addEventListener('keyup', function () {
   if (this.value != "") {
       verificar.disabled = false;
   } 
   else{
    verificar.disabled = true;
   }
});

verificar.addEventListener('click', function () {
    const infoHabitacion = new FormData();
    infoHabitacion.append('Habitacion', campoHab.value);
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
            contenedorPrincipal.hidden = false;
            var informacion = JSON.parse(texto);
            IDHabitacion = informacion.Habitacion_ID;
            iniciarTarjeta("Rojo", "Azul", informacion.Huesped_Nombre, informacion.Huesped_Apellidos, informacion.Habitacion_Nombre);
        }
        else{
            iniciarTarjeta("Azul", "Rojo", "Nombre", "Apellidos", "Habitacion");

            while (contenedorEntradas.firstChild) {
                contenedorEntradas.removeChild(contenedorEntradas.firstChild);
            }
            contador = 0;
            contenedorPrincipal.hidden = true;
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

function agregarFila() {
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
    iNum.addEventListener("change", cambioNumero);
    //Agregar texto al h1 (PROVISIONAL)
    var textoP = document.createTextNode("$0");
    precio.appendChild(textoP);
    precio.classList.add("TPrecio");
    //-------------SELECTS---------
    //SELECT CATEGORIA
    //Crear Select
    var iCategoria = document.createElement('select')
    //Agregar clases 
    iCategoria.classList.add('EntradaTexto');
    iCategoria.classList.add('Campo30');
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
    //Agregar opciones
    obtenerProductos(categorias[0].CatProd_ID, iElemento, iNum);
    iElemento.addEventListener('change', cambioElemento);
    // crearOpciones(iElemento, productos);
    //-------------SELECTS---------
    // precio.innerHTML = iElemento.value;
    
    //Agregar elementos
    iDiv.appendChild(iCategoria);
    iDiv.appendChild(iElemento);
    iDiv.appendChild(iNum);
    iDiv.appendChild(precio);
    iDiv.appendChild(br);
    contenedorEntradas.appendChild(iDiv);

    //Añadir al contador
    contador = contador+1;
    console.log(contador);
    console.log(iElemento.options);
    var OpcionSeleccionada = iElemento.options;
}

function iniciarTarjeta(colorA, colorN, Nombre, Apellidos, Habitacion) {
    Tarjeta.classList.remove(colorA);
    Tarjeta.classList.add(colorN);
    TarHabitacion.innerHTML = Habitacion;
    TarNombre.innerHTML =Nombre;
    TarApellidos.innerHTML = Apellidos;
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
            iOpcion.setAttribute("value", element.Producto_Precio);
            iOpcion.innerHTML=element.Producto_Nombre;
            
        }
        Select.appendChild(iOpcion);
    });
}

function obtenerProductos(categoria, Select, Cantidad) {
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
                crearOpciones(Select, productos);
                console.log(productos[0].Producto_Precio);
                console.log(Cantidad);
                actualizarPrecio(Cantidad, productos[0].Producto_Precio);
            }
         })
         .catch(function(err) {
            console.log(err);
         });
         return productos;
}

function CambiarOpciones() {

    while (this.nextSibling.firstChild) {
        this.nextSibling.remove(this.nextSibling.firstChild);
    }
    obtenerProductos(this.value, this.nextSibling, this.nextSibling.nextSibling);
}

function actualizarTarjeta() {
    var cantidad;
    var precio;
    const Productos = document.querySelectorAll(".SProducto");
    Productos.forEach(element => {
        console.log(element);
        
    });

}

function actualizarPrecio(Cantidad, PrecioUnitario) {
    const TextoPrecio = Cantidad.nextSibling;
    verificarFase();
    TextoPrecio.innerHTML = "$"+Cantidad.value *PrecioUnitario;
}

function cambioNumero() {
    precio = this.nextSibling.innerHTML.slice(1);
    precio = precio/this.value;
    console.log();
    console.log(this.value);
    actualizarPrecio(this, this.previousSibling.value);
}

function cambioElemento() {
    actualizarPrecio(this.nextSibling, this.value);

}

function verificarFase() {
    if (fase != 0) {
        btnCompletar.classList.remove("Verde");
        btnCompletar.classList.add("Naranja");
        btnCompletar.innerHTML = "Verificar";
        fase = 0;
    }
}

btnCompletar.addEventListener("click", function () {
   switch (fase) {
       case 0:
           var precios = document.querySelectorAll(".TPrecio");
           var precioTotal= 0;
           precios.forEach(element => {
               console.log(element);
               var precio = element.innerHTML.slice(1);
               var numPrecio = parseInt(precio);
               precioTotal+=numPrecio;
           });
           PTOTAL = precioTotal;
           TarCantidad.innerHTML = "Cantidad = "+precios.length;
           TarPrecio.innerHTML = "Precio Total = $"+precioTotal;
           fase = 1;
           btnCompletar.classList.remove("Naranja");
           btnCompletar.classList.add("Verde");
           btnCompletar.innerHTML = "Completar";
        break;
        case 1:
            const infoServicio = new FormData();
            infoServicio.append('Habitacion', IDHabitacion);
            infoServicio.append('Precio', PTOTAL);
            fetch('../backend/solicitudServicio.php', {
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
                console.log(texto);
                var ServicioID = texto;
                IDServicio = ServicioID;
                var Productos = document.querySelectorAll(".SProducto");
                Productos.forEach(element => {
                    var ProdID = element.options[element.selectedIndex].id;
                    var Cant = element.nextSibling.value;
                    ordenarCarrito(ServicioID, ProdID, Cant);
                });
            })
            .catch(function(err) {
                console.log(err);
            });
            fase = 2;
            btnCompletar.classList.remove("Verde");
            btnCompletar.classList.add("Rojo");
            btnCompletar.innerHTML = "Cancelar";
        break;
        case 2:
           cancelar(IDServicio);
        break;
       default:
           alert("ERROR FASE "+ fase);
           break;
   }
});

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


function cancelar(ServicioID) {
    const infoCancelacion = new FormData();
            infoCancelacion.append('Servicio', ServicioID);
            fetch('../backend/cancelarServicio.php', {
                method:'POST',
                body: infoCancelacion
            })
            .then(function(response){
                if(response.ok) {
                    return response.text();
                } else {
                    throw "Error en la llamada Ajax";
                }
            })
            .then(function(texto) {
                if (texto == "0") {
                    alert("Cancelado con exito");
                    while (contenedorEntradas.firstChild) {
                        contenedorEntradas.removeChild(contenedorEntradas.firstChild);
                    }
                    TarPrecio.innerHTML ="Precio Total = $0"
                    TarCantidad.innerHTML = "Cantidad";
                    contador = 0;
                }
            })
            .catch(function(err) {
                console.log(err);
            });
}