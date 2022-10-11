const tablaServicios = document.querySelector('.tablaServicios');
console.log(tablaServicios);
const fragment = document.createDocumentFragment();
var enviarID = new FormData();
const checkbox = document.getElementById("cbox");
const btnAdd = document.querySelector('.btnAdd');
const btnBuscar = document.getElementById("btnBuscar");
const barra = document.getElementById("barraBusqueda");
const indicador = document.getElementById("indicadorPrecio");
var OrdenDES = "ORDER BY Producto_Precio DESC";
console.log(btnAdd);

window.addEventListener('load', cargarTabla);
checkbox.addEventListener('change', function () {
   if (this.checked) {
    indicador.innerHTML = "Menor precio";
    OrdenDES = "ORDER BY Producto_Precio ASC";
   }
   else{
    indicador.innerHTML = "Mayor precio";
    OrdenDES = "ORDER BY Producto_Precio DESC";
   }
});
btnBuscar.addEventListener("click", function (e) {
    e.preventDefault();
    cargarTabla();

});
function cargarTabla() {
    while (tablaServicios.firstChild) {
        tablaServicios.removeChild(tablaServicios.firstChild);
    }

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

            const tdCategoria = document.createElement('td');
            tdCategoria.classList.add('nombreServicio');
            tdCategoria.textContent = element.catprod_categoria;

            const tdPrecio = document.createElement('td');
            tdPrecio.classList.add('nombreServicio');
            tdPrecio.textContent = "$"+element.producto_precio;
            tr.appendChild(tdNombre);
            tr.appendChild(tdCategoria);
            tr.appendChild(tdPrecio);
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
            btnVer.addEventListener('click', interVerProducto);
            tdBoton.appendChild(btnVer);
            tr.appendChild(tdBoton);
            const ProdNombre = element.producto_nombre.toUpperCase();
            const ProdCat = element.catprod_categoria.toUpperCase();
            const Busqueda = barra.value.toUpperCase();
            if (barra.value != "") {
                if (ProdNombre.includes(Busqueda) || ProdCat.includes(Busqueda)) {
                    fragment.appendChild(tr);
                }
            }
            else{
                fragment.appendChild(tr);
            }
            
            console.log(tr);
        }     
        tablaServicios.appendChild(fragment);
    })
}
function interVerProducto() {
    var productoID = this.id;
    verProducto(productoID);
}
function verProducto(PID) {
    enviarID.append('id',PID);
    localStorage.setItem("productoID", PID);
    window.location.href="https://corporativotdo.com/Administrador/moduloServicios/verServicioEspecifico/verServicioEspecifico.php";
}
btnAdd.addEventListener('click', e =>{
    window.location.href= "https://corporativotdo.com/Administrador/moduloServicios/registrarServicio/registrarServicio.php";
})