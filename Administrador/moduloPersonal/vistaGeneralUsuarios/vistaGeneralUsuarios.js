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


            const btnVer = document.createElement('button');
            btnVer.classList.add('ver');
            btnVer.id = element.personal_id;
            
            btnVer.textContent = 'Ver';
            tdBoton.appendChild(btnVer);
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
            localStorage.setItem("personalID", personalID);
            window.location.href="http://localhost/Buhitel/Administrador/moduloPersonal/verPersonalEspecifico/verPersonalEspecifico.php";
           
        }
    })

})

