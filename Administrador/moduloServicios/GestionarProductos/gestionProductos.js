const checkbox = document.getElementById("cbox");
const selectCategoria = document.getElementById("SelectCategoria");
const selectProducto = document.getElementById("SelectProducto");

class Producto{
    constructor(id, nombre, estado){
        this.id = id;
        this.nombre = nombre;
        this.estado = estado;
    }
}

var LProductos = [];

checkbox.addEventListener('change', function () {
   let ProductoActual = LProductos.find(element => element.id === selectProducto.value);
   let Estado = ProductoActual.estado;
   let ProductoActualID = ProductoActual.id;
   let NuevoEstado;
   switch (Estado) {
    case "1":
        NuevoEstado = 0;
    break;
    case "0":
        NuevoEstado = 1;
    break;
   
    default:
        break;
   }

   var infoCategoria = new FormData();
    infoCategoria.append("Producto", ProductoActualID);
    infoCategoria.append("Existencia", NuevoEstado);
    fetch('../backendModuloServicios/cambiarExistencia.php', {
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
       if (texto == "1") {
        console.log("tobien");
       }
     })
     .catch(function(err) {
        console.log(err);
     });
});

window.addEventListener("load", function () {
    checkbox.hidden = true;
     //CONSULTA
     fetch('../backendModuloServicios/consultarCategorias.php', {
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
        console.log(texto);
        if (texto != "0") {
            let categorias = JSON.parse(texto);
            categorias.forEach(categoria => {
                let opcion = document.createElement("option");
                opcion.innerHTML = categoria.CatProd_Categoria;
                opcion.setAttribute("value", categoria.CatProd_ID);
                selectCategoria.appendChild(opcion);
            });
        }
     })
     .catch(function(err) {
        console.log(err);
     });
})

selectCategoria.addEventListener("change", function () {
   while (selectProducto.firstChild) {
    selectProducto.removeChild(selectProducto.firstChild);
    }

    var infoCategoria = new FormData();
    infoCategoria.append("Categoria", selectCategoria.value);
    fetch('../backendModuloServicios/consultarProductos.php', {
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
       LProductos = [];

        console.log(texto);
        if (texto != "0") {
            let productos = JSON.parse(texto);
            productos.forEach(producto => {
                let opcion = document.createElement("option");
                opcion.innerHTML = producto.Producto_Nombre;
                opcion.setAttribute("value", producto.Producto_ID);
                opcion.setAttribute("name", producto.Producto_Existencia);
                selectProducto.appendChild(opcion);
                var Prod = new Producto(producto.Producto_ID, producto.Producto_Nombre, producto.Producto_Existencia);
                LProductos.push(Prod);
            });
            cambiarCB();
            console.log(LProductos);
        }
     })
     .catch(function(err) {
        console.log(err);
     });

});

selectProducto.addEventListener("change", cambiarCB);

function cambiarCB() {
    let ProductoActual = LProductos.find(element => element.id === selectProducto.value);
    let Estado = ProductoActual.estado;
    switch (Estado) {
     case "1":
         checkbox.checked = true;
     break;
     case "0":
         checkbox.checked = false;
     break;
    
     default:
         break;
    }
}