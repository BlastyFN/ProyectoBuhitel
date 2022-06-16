const formRegistroUsuario = document.querySelector('.formNuevoUsuario');
const obtenerInfo = new FormData();
const enviarRegistro = new FormData();

const nombre = document.getElementById('nombreUsr');
const categoria = document.getElementById('categoria');
const precio = document.getElementById('precio');
const existencia = document.getElementById('existencia');
const descripcion = document.getElementById('descripcion');
const opcAgotado = document.getElementById('false');
const opcStock = document.getElementById('true');


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
})


formRegistroUsuario.addEventListener('submit', function(e){
    e.preventDefault();    

    enviarRegistro.append('nombres',nombre.value);
    enviarRegistro.append('apellidoP',categoria.value);
    enviarRegistro.append('apellidoM',inputApellidoM.value);
    enviarRegistro.append('tipoPersonal', inputTipoPersonal.value);
    enviarRegistro.append('correo',inputCorreo.value);
    enviarRegistro.append('password',inputContraseña.value);
    enviarRegistro.append('seguroSocial',inputSeguroSocial.value);
   
    

    fetch('../backendModuloPersonal/modificarPersonal.php' , {
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