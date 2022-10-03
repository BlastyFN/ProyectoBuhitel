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


window.addEventListener('load',e=>{
    obtenerInfo.append('productoID',localStorage.getItem("productoID"));
    fetch('../backendModuloPersonal/obtenerServicioEspecifico.php' , {
        method:'POST', body:obtenerInfo
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(infoServicio){
        console.log(infoServicio);
        for(element of infoServicio){
            nombre.value = element.Producto_Nombre;
            categoria.value = element.CatProd_Categoria; 
            precio.value = element.Producto_Precio;
            descripcion.value = element.Producto_Descripcion;
            
           
        }
    })

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
        for(element of res){  //Por cada elemento del json
            
            var inputCategoria = document.createElement('option');
            inputCategoria.setAttribute('value',element.CatProd_ID);
            inputCategoria.textContent = element.CatProd_Categoria;
            console.log(inputCategoria.value);
            fragment.appendChild(inputCategoria);
            
        }
        
        opciones.appendChild(fragment);
        cargarInfoTipoHab(opciones.value);
    });
})


formRegistroServicio.addEventListener('submit', function(e){
    e.preventDefault();    

    enviarRegistro.append('nombres',nombre.value);
    enviarRegistro.append('apellidoP',categoria.value);
    enviarRegistro.append('apellidoM',inputApellidoM.value);
    enviarRegistro.append('tipoPersonal', inputTipoPersonal.value);


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