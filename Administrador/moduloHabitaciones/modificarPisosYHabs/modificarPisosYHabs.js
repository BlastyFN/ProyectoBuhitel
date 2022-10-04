var IDpisos = new Array();
var antiguosValores = new Array();
var num;


addEventListener('load', function(){
    obtenerPisos();

});

document.addEventListener('click',function(e){
    if(e.target && e.target.classList == 'modificarInfo'){
        e.preventDefault();
        let inputs = Array.prototype.slice.call(document.getElementsByClassName("campo"), 0);
        console.log(antiguosValores);
        console.log(inputs);
        var values = new Array();
        for(var cont = 0; cont < IDpisos.length;cont++){
            if (antiguosValores[cont] != inputs[cont].value ){
                pedirCambio(antiguosValores[cont],inputs[cont].value,IDpisos[cont]);
                antiguosValores[cont]=inputs[cont].value;
            }
        }
    }
 });

 document.addEventListener('click',function(e){
    if(e.target && e.target.classList == 'agregarPiso'){
        e.preventDefault();
        const contForm = document.querySelector(".enviarModificacion");
        const btnAgregar = document.querySelector(".agregarPiso");
        const contPiso = document.createElement('div');
            contPiso.classList.add('contPiso');
            //Se crea el contenedor de la info de cada piso
            const contInfoPiso = document.createElement('div');
            contInfoPiso.classList.add('contInfoPiso');
            contInfoPiso.textContent = "Piso " + (IDpisos.length + 1) + " \rNúmero de habitaciones";
           
            //Se crea el input que recibe el valor para la modificación
            const inputNumHabs = document.createElement('input');
            inputNumHabs.setAttribute("type","number");
            //obtenerHabsPorPiso(element.piso_ID,inputNumHabs);
            inputNumHabs.classList.add("campo");
            contInfoPiso.appendChild(inputNumHabs);
            //Se crea el botón de eliminar

            contPiso.appendChild(contInfoPiso);
      
            
            //contPiso.innerHTML = HTMLString; 
            btnAgregar.parentNode.insertBefore(contPiso,btnAgregar);
            añadirPiso(IDpisos.length + 1);

    }
 });

 
document.addEventListener('click',function(e){
    if(e.target && e.target.classList == 'eliminarPiso'){
        e.preventDefault();
        eliminarPiso(IDpisos[IDpisos.length - 1]);
    }
 });

function eliminarPiso(pisoID){
    const eliminarPiso = new FormData();
    eliminarPiso.append("pisoID",pisoID);

    fetch("../backend/eliminarPiso.php", {
        method:'POST', body: eliminarPiso
    }).then(function(response){
        if(response.ok){
            return response.text();
        } else {
               throw "Error en la llamada Ajax"
        }      
    }).then(function(res){
        alert(res);
        console.log(res);
        IDpisos.pop();
        
    });
}

 function añadirPiso(piso){
    const registrarPiso = new FormData();
    registrarPiso.append("piso",piso);

    fetch("../backend/registrarPiso.php", {
        method:'POST', body: registrarPiso
    }).then(function(response){
        if(response.ok){
            return response.text();
        } else {
               throw "Error en la llamada Ajax"
        }      
    }).then(function(res){
        alert(res);
        console.log(res);
        IDpisos.push(res);
        
    });
 }

 function pedirCambio(antiguoNumHabs,nuevoNumHabs,pisoID){
    const cambioNumHabs = new FormData();
    cambioNumHabs.append("antiguoNumHabs",antiguoNumHabs);
    cambioNumHabs.append("nuevoNumHabs",nuevoNumHabs);
    cambioNumHabs.append("pisoID",pisoID);
    fetch("../backend/cambiarNumHabs.php", {
        method:'POST', body: cambioNumHabs
    }).then(function(response){
        if(response.ok){
            return response.text();
        } else {
               throw "Error en la llamada Ajax"
        }      
    }).then(function(res){
        alert(res);
        console.log(res);
        
    });
 }


function obtenerPisos(){
    this.preventDefault;

    fetch("../backend/obtenerPisos.php", {
        method:'POST'
    }).then(function(response){
        if(response.ok){
            return response.json();
           } else {
               throw "Error en la llamada Ajax"
           }      
    }).then(function(res){
        console.log(res);
        const contTarjetas = document.querySelector(".contenedorPisos");
        const fragment = document.createDocumentFragment();

        const form = document.createElement('form');
        form.setAttribute("method","post");
        form.classList.add("enviarModificacion");
        
        for(element of res){
            console.log("el id es de " +element.piso_ID);
            IDpisos.push(element.piso_ID);
            console.log(IDpisos);
            //Se crea el contenedor de cada piso
 
            const contPiso = document.createElement('div');
            contPiso.classList.add('contPiso');
            //Se crea el contenedor de la info de cada piso
            const contInfoPiso = document.createElement('div');
            contInfoPiso.classList.add('contInfoPiso');
            contInfoPiso.textContent = "Piso " + element.piso_numero + " \rNúmero de habitaciones";
           
            //Se crea el input que recibe el valor para la modificación
            const inputNumHabs = document.createElement('input');
            inputNumHabs.setAttribute("type","number");
            obtenerHabsPorPiso(element.piso_ID,inputNumHabs);
            inputNumHabs.classList.add("campo");
            contInfoPiso.appendChild(inputNumHabs);
            //Se crea el botón de eliminar

            contPiso.appendChild(contInfoPiso);
            
            
            form.appendChild(contPiso);
        }
        console.log(antiguosValores);
        const btnAgregar = document.createElement("button");      
        btnAgregar.classList.add("agregarPiso");
        btnAgregar.textContent = "agregar Piso";
        form.appendChild(btnAgregar);
        
        const btnEliminar = document.createElement("button");      
        btnEliminar.classList.add("eliminarPiso");
        btnEliminar.textContent = "eliminar Piso";
        form.appendChild(btnEliminar);

        const btnModificar = document.createElement("button");
        btnModificar.setAttribute("type", "submit");
        btnModificar.classList.add("modificarInfo");
        btnModificar.textContent = "Modificar";
        form.appendChild(btnModificar);
        fragment.appendChild(form);
        contTarjetas.appendChild(fragment);
        console.log(contTarjetas);

    });    

}

function obtenerHabsPorPiso(pisoID,input){
    var num;
    const solicitarNumHabs = new FormData();
    solicitarNumHabs.append("piso",pisoID);
    fetch("../backend/obtenerNumHabsPorPiso.php", {
        method:'POST', body: solicitarNumHabs
    }).then(function(response){
        if(response.ok){
            
            return response.text();
            
           } else {
               throw "Error en la llamada Ajax"
           }      
    }).then(function(resHabs){
        console.log(resHabs);
        input.value = resHabs;
        antiguosValores.push(resHabs);
        
    });


}

