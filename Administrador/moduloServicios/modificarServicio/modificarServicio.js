const formRegistroServicio = document.querySelector('.formNuevoServicio');
const obtenerInfo = new FormData();
const enviarRegistro = new FormData();

const opciones = document.getElementById('opcCategorias');
const nombre = document.getElementById('nombre');
const categoria = document.getElementById('categoria');
const precio = document.getElementById('precio');
const existencia = document.getElementById('existencia');
const descripcion = document.getElementById('descripcion');
const opcAgotado = document.getElementById('agotado');
const opcStock = document.getElementById('stock');
var categoriaProducto;


window.addEventListener('load',e=>{

    fetch('../backendModuloServicios/consultarCategorias.php' , {
        method:'POST'
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(res){
        console.log(res);
        const fragment = document.createDocumentFragment();
        for(element of res){  //Por cada elemento del json
            
            var inputCategoria = document.createElement('option');
            inputCategoria.setAttribute('value',element.CatProd_ID);
            inputCategoria.textContent = element.CatProd_Categoria;
            if (element.CatProd_ID == categoriaProducto){
                
            }
            console.log(inputCategoria.value);
            fragment.appendChild(inputCategoria);
            
        }
        opciones.appendChild(fragment);
        obtenerInfoServicio();
   
    });
})


formRegistroServicio.addEventListener('submit', function(e){
    e.preventDefault();    
    enviarRegistro.append('productoID',localStorage.getItem('productoID'));
    enviarRegistro.append('nombre',nombre.value);
    enviarRegistro.append('categoria',categoria.value);
    enviarRegistro.append('precio',precio.value);
    enviarRegistro.append('descripcion', descripcion.value);


    fetch('../backendModuloPersonal/modificarServicio.php' , {
        method:'POST', body:enviarRegistro
    }).then(function(response){
        if(response.ok){
         return response.text();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(texto){
        console.log(texto);
        alert(texto);
    })
});

function obtenerInfoServicio(){
    fetch('../backendModuloServicios/obtenerServicioEspecifico.php' , {
        method:'POST', body:obtenerInfo
    }).then(function(response){
        if(response.ok){
         return response.text();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(infoServicio){
        console.log(infoServicio);
        for(element of infoServicio){
            nombre.value = element.Producto_Nombre;
            opciones.value = element.CatProd_Categoria; 
            precio.value = element.Producto_Precio;
            descripcion.value = element.Producto_Descripcion;
            
           
        }
    })
}