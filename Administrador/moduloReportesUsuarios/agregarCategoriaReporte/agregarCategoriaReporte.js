const dragArea = document.querySelector(".wrapper");
const btnEnviar = document.querySelector(".btnEnviar");
const inputNombre = document.getElementById("inputNombre");
const fragment = document.createDocumentFragment();

new Sortable (dragArea, {
    animation:350
})

inputNombre.addEventListener('keyup', ()=>{
    if(inputNombre.value == ""){
        btnEnviar.disabled = true;    
    }else{
        btnEnviar.disabled = false;
        var spanNombre = document.getElementById('nuevaCat');
        spanNombre.textContent = inputNombre.value;
    }
})



window.addEventListener('load', ()=>{

    const divItem = document.createElement('div');
    divItem.classList.add('item', "nuevaCat");
    const spanNombreCat = document.createElement('span');
    spanNombreCat.setAttribute("id","nuevaCat");
    spanNombreCat.classList.add('nombreCat');
    spanNombreCat.textContent = "Nueva categoría";
    divItem.appendChild(spanNombreCat);
    fragment.appendChild(divItem);
    
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

