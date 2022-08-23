const tablaReportes = document.querySelector('.tablaReportes');
const fragment = document.createDocumentFragment();

var enviarID = new FormData();

window.addEventListener('load', e => {
    fetch('../backend/obtenerReportes.php' , {
        method:'POST'
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(listaReportes){
        console.log(listaReportes);
        for(element of listaReportes){
            const tr = document.createElement('tr');
            const tdNombre = document.createElement('td');
            tdNombre.classList.add('nombreReporte');
            tdNombre.textContent = element.Reporte_Nombre;
            tr.appendChild(tdNombre);
            
            const tdCategoria = document.createElement('td');
            tdCategoria.textContent = element.CatReporte_Nombre;
            tr.appendChild(tdCategoria);

            const tdBoton = document.createElement('td');


            const btnVer = document.createElement('button');
            btnVer.classList.add('ver');
            btnVer.id = element.Reporte_ID;
            
            btnVer.textContent = 'Ver';
            tdBoton.appendChild(btnVer);
            tr.appendChild(tdBoton);

            fragment.appendChild(tr);
            console.log(tr);
        }
        
        tablaReportes.appendChild(fragment);

        
    })
})

document.addEventListener('DOMContentLoaded', () => {

    tablaReportes.addEventListener('click', e =>{
        if(e.target.classList.contains('ver')){
            var reporteID = e.target.id;
            enviarID.append('id',e.reporteID);
            localStorage.setItem("reporteID", reporteID);
            window.location.href="https://corporativotdo.com/Administrador/moduloReportesUsuarios/vistaReporteUsuario/vistaReporteUsuario.php";
           
        }
    })

})