const formRegistroServicio = document.querySelector('.formNuevoServicio');
const obtenerInfo = new FormData();
const enviarRegistro = new FormData();

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
            inputNombres.value = element.Producto_Nombre;
            categoria.value = element.CatProd_Categoria; 
            precio.value = element.Producto_Precio;
            descripcion.selectedIndex = 1;
            
           
        }
    })

    fetch('../backend/consultarCategorias.php' , {
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
            
            var inputTipoHab = document.createElement('option');
            inputTipoHab.setAttribute('value',element.tipohab_ID);
            inputTipoHab.textContent = element.tipohab_nombre;
            console.log(inputTipoHab.value);
            fragment.appendChild(inputTipoHab);
            
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