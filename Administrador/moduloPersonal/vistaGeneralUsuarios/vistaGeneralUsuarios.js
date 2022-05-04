const tablaPersonal = document.querySelector('.tablaPersonal');
console.log(tablaPersonal);
const fragment = document.createDocumentFragment();
var enviarID = new FormData();


window.addEventListener('load', e => {
    fetch('../backendModuloPersonal/obtenerPersonal.php' , {
        method:'POST'
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(listaPersonal){
        console.log(listaPersonal);
        for(element of listaPersonal){
            const tr = document.createElement('tr');
            const tdNombre = document.createElement('td');
            tdNombre.classList.add('nombrePersonal');
            tdNombre.textContent = element.personal_nombre + " " 
                + element.personal_apaterno + " " + element.personal_amaterno;
            tr.appendChild(tdNombre);
            
            const tdTipoPersonal = document.createElement('td');
            tdTipoPersonal.textContent = element.personal_tipo;
            tr.appendChild(tdTipoPersonal);

            const tdBoton = document.createElement('td');
            const formID = document.createElement('form');
            formID.setAttribute('action','../verPersonalEspecifico/verPersonalEspecifico.php');
            formID.setAttribute('method','POST');
            const idValue = document.createElement('input');
            idValue.setAttribute('type','hidden');
            idValue.setAttribute('name','id');
            idValue.setAttribute('value',element.personal_id);

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
        
        tablaPersonal.appendChild(fragment);
    })
})

document.addEventListener('DOMContentLoaded', () => {

    tablaPersonal.addEventListener('click', e =>{
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