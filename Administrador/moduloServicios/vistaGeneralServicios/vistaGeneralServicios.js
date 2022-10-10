const tablaServicios = document.querySelector('.tablaServicios');
console.log(tablaServicios);
const fragment = document.createDocumentFragment();
var enviarID = new FormData();
const btnAdd = document.querySelector('.btnAdd');
const OrdenDES = "ORDER BY Producto_Precio ASC";
console.log(btnAdd);

window.addEventListener('load', e => {
    const Criterios = new FormData();
    Criterios.append("Orden", OrdenDES);
    fetch('../backendModuloServicios/obtenerServicios.php' , {
        method:'POST',
        body: Criterios
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(listaServicios){
        console.log(listaServicios);
        for(element of listaServicios){
            const tr = document.createElement('tr');
            const tdNombre = document.createElement('td');
            tdNombre.classList.add('nombreServicio');
            tdNombre.textContent = element.producto_nombre;
            tr.appendChild(tdNombre);
            
            const existencia = document.createElement('td');
            if(element.producto_existencia == 1){
                existencia.textContent = "En stock";
            } else {
                existencia.textContent = "Agotado";
            }
        
            tr.appendChild(existencia);

            const tdBoton = document.createElement('td');
            const btnVer = document.createElement('button');
            btnVer.classList.add('ver');
            btnVer.setAttribute('id', element.producto_id);
            btnVer.textContent = 'Ver';
    
            tdBoton.appendChild(btnVer);
            tr.appendChild(tdBoton);

            fragment.appendChild(tr);
            console.log(tr);
        }     
        tablaServicios.appendChild(fragment);
    })
})

document.addEventListener('DOMContentLoaded', () => {

    tablaServicios.addEventListener('click', e =>{
        if(e.target.classList.contains('ver')){
            var productoID = e.target.id;
            enviarID.append('id',productoID);
            localStorage.setItem("productoID", productoID);
            window.location.href="https://corporativotdo.com/Administrador/moduloServicios/verServicioEspecifico/verServicioEspecifico.php";
           
           
        }
})

})

btnAdd.addEventListener('click', e =>{
    window.location.href= "https://corporativotdo.com/Administrador/moduloServicios/registrarServicio/registrarServicio.php";
})