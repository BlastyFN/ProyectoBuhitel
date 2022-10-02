const titulo = document.querySelector('.titulo');
const nombre = document.querySelector('.nombre');
const tipo = document.querySelector('.tipo');
const precio = document.querySelector('.precio');
const descripcion = document.querySelector('.descripcion');
const existencia = document.querySelector('.existencia');
const btnVolver = document.querySelector('.volver');
const btnModificar = document.querySelector('.modificar');
const pedirServicio = new FormData();


window.addEventListener('load', e => {
    console.log(localStorage.getItem("productoID"));
    pedirServicio.append('productoID',localStorage.getItem("productoID"))
    fetch('../backendModuloServicios/obtenerServicioEspecifico.php' , {
        method:'POST', body: pedirServicio
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(infoProducto){
        console.log(infoProducto);
        for(element of infoProducto){
            titulo.textContent = "Mostrando la información de " + element.Producto_Nombre;
            nombre.textContent = "Nombre: " + element.Producto_Nombre;
            tipo.textContent = "Categoría: " + element.CatProd_Categoria;
            precio.textContent = "Precio: " + element.Producto_Precio;
            descripcion.textContent = "Descripción: " + element.Producto_Descripcion;
            if(element.producto_existencia == 1)
            existencia.textContent = "Existencia del producto: En stock";
            else
            existencia.textContent = "Existencia del producto: Agotado";
        }
    })
})

btnVolver.addEventListener('click', e =>{
    
    window.location.href = "https://corporativotdo.com/Administrador/moduloServicios/vistaGeneralServicios/vistaGeneralServicios.php";
})

btnModificar.addEventListener('click',e =>{
    window.location.href = "https://corporativotdo.com/Administrador/moduloServicios/modificarServicio/modificarServicio.php";
})