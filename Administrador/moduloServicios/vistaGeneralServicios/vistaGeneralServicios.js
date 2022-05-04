const tablaServicios = document.querySelector('.tablaServicios');
console.log(tablaServicios);
const fragment = document.createDocumentFragment();
var enviarID = new FormData();


window.addEventListener('load', e => {
    fetch('../backendModuloServicios/obtenerServicios.php' , {
        method:'POST'
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
            
            const tdTipoProducto = document.createElement('td');
            tdTipoProducto.textContent = element.producto_categoria;
            tr.appendChild(tdTipoProducto);

            const tdBoton = document.createElement('td');
            const formID = document.createElement('form');
            formID.setAttribute('action','../verPersonalEspecifico/verServicioEspecifico.php');
            formID.setAttribute('method','POST');
            const idValue = document.createElement('input');
            idValue.setAttribute('type','hidden');
            idValue.setAttribute('name','id');
            idValue.setAttribute('value',element.producto_id);

            const btnVer = document.createElement('button');
            btnVer.classList.add('ver');
            btnVer.setAttribute('type','submit');
            btnVer.textContent = 'Ver';
            formID.appendChild(idValue);
            formID.appendChild(btnVer);
            tdBoton.appendChild(formID);
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
            var personalID = e.target.id;
            enviarID.append('id',e.personalID);
            $.ajax({
                method: 'POST',
                url: "../verPersonalEspecifico.php",
                data: enviarID,
                success: function(respuesta){}
            });
           
        }
})

})