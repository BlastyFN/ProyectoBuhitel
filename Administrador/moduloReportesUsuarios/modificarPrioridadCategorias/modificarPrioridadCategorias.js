const dragArea = document.querySelector(".wrapper");
const btnEnviar = document.querySelector(".btnEnviar");

const fragment = document.createDocumentFragment();

new Sortable (dragArea, {
    animation:350
})



window.addEventListener('load', ()=>{

    
    fetch('../backend/obtenerCategoriaReportes.php' , {
        method:'POST'
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(listaCatReportes){
        console.log(listaCatReportes);
        listaCatReportes.forEach(element => {
            const divItem = document.createElement('div');
            divItem.classList.add('item');
            const spanNombreCat = document.createElement('span');
            spanNombreCat.classList.add('nombreCat');
            spanNombreCat.textContent = element.CatReporte_Nombre;
            divItem.appendChild(spanNombreCat);
            fragment.appendChild(divItem);
        });



        dragArea.appendChild(fragment);
    })
})

btnEnviar.addEventListener('click',()=>{
    let nombresCat = new Array();
    var listaCats = document.querySelectorAll('.nombreCat');
    listaCats.forEach(element => {
        nombresCat.push(element.textContent);
    });
    console.log(nombresCat);
    console.log(JSON.stringify(nombresCat));
    const enviarCats = new FormData();
    enviarCats.append('listaNombresCats',JSON.stringify(nombresCat));

    fetch('../backend/organizarCategorias.php' , {
        method:'POST', body:enviarCats
    }).then(function(response){
        if(response.ok){
         return response.text();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(listaCatReportes){
        console.log(listaCatReportes);
    
    })

})

