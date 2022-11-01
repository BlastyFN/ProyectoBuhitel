const CHabitacion = document.getElementById('cmpHabitacion');
const CModelo = document.getElementById('cmpModelo');
const CColor = document.getElementById('cmpColor');
const CPlacas = document.getElementById('cmpPlacas');
const CLugar = document.getElementById('cmpLugar');
const CNotas = document.getElementById('cmpNotas');
const NCampos = document.querySelectorAll('input');
const LineasVehiculo = document.querySelectorAll('tbody > tr');
const CampoHabitacion = document.getElementById("cmpHabitacion");
const btnConfirmar = document.getElementById('btnConfirmar');
const infoVehiculo = document.getElementById("InfoVehiculo");
const infoTabla = document.getElementById('CuerpoTabla');
var Vehiculos = [];
//LA CLASE QUE SE USARÁ PARA LAS LINEAS
class Vehiculo { 
    constructor(Placas, Habitacion, Modelo, Color, Lugar, Notas){
        this.Placas = Placas;
        this.Habitacion = Habitacion;
        this.Modelo = Modelo;
        this.Color = Color;
        this.Lugar = Lugar;
        this.Notas = Notas;
    }
}


//Cargar tabla cuando se carga la ventana
window.addEventListener('load', cargarTabla);

function cargarTabla() {
    //Elimina los elementos de la tabla
    while (infoTabla.firstChild) {
        infoTabla.removeChild(infoTabla.firstChild);
    }
    //Elimina los elementos del arreglo
    while (Vehiculos.length > 0){
        Vehiculos.pop();
    }
    fetch('../backend/consultarVehiculos.php', {
        method:'POST',
    })
    .then(function(response){
        if(response.ok) {
            return response.text();
        } else {
            throw "Error en la llamada Ajax";
        }
    })
    .then(function(texto) {
        if (texto != "0") {
            let jsonVeh;
            jsonVeh = JSON.parse(texto);
            console.log(jsonVeh);
            //Crea el objeto
            jsonVeh.forEach(element => {
                const VH = new Vehiculo(
                    element.Vehiculo_Placas,
                    element.Habitacion_Nombre,
                    element.Vehiculo_Modelo,
                    element.Vehiculo_Color,
                    element.Vehiculo_LugarEstacionamiento,
                    element.Vehiculo_Notas
                );
                //Añade el objeto al array de objetos
                Vehiculos.push(VH);
                //Crea cada línea con al información obtenida del JSON
                var iFila = document.createElement('tr');
                var iHabitacion = document.createElement('td');
                var iModelo = document.createElement('td');
                var iPlacas = document.createElement('td');
                iHabitacion.appendChild(document.createTextNode(element.Habitacion_Nombre));
                iModelo.appendChild(document.createTextNode(element.Vehiculo_Modelo));
                iPlacas.appendChild(document.createTextNode(element.Vehiculo_Placas));
                iFila.appendChild(iHabitacion);
                iFila.appendChild(iModelo);
                iFila.appendChild(iPlacas);
                //Añade el evento de cada fila para seleccionar el vehículo
                iFila.addEventListener('click', obtenerVeh);
                infoTabla.appendChild(iFila);
            }); 
            console.log(Vehiculos);
        }else{
            alert("No hay vehículos");
        }
        
     })
     .catch(function(err) {
        console.log(err);
     });
}

//Verifica los campos
function verificarBoton() {
    contador = 0;
    NCampos.forEach(element => {
        if (element.value != "") {
            contador++    
        }
        
    });
    if (contador == 5 && CPlacas.value.length > 4 && CColor.value.length > 4) {

        btnConfirmar.disabled = false;
        
         
    }
    else{
        btnConfirmar.disabled = true;
    }
}

//Añade el evento de verificar boton cada que se actualiza un campo
NCampos.forEach(element => {
    element.addEventListener('keyup', verificarBoton);
});
//Obtiene el vehículo seleccionado y lo imprime en el formulario
function obtenerVeh() {
    var Hab = this.querySelector('td').textContent;
    console.log(Hab);
    var Coche = Vehiculos.find(element => element.Habitacion === Hab);
    CHabitacion.value = Coche.Habitacion;
    CModelo.value = Coche.Modelo;
    CColor.value = Coche.Color;
    CPlacas.value = Coche.Placas;
    CLugar.value = Coche.Lugar;
    CNotas.value = Coche.Notas;
    btnConfirmar.disabled = false;
}
//Añade el vehículo o lo edita según sea el caso
btnConfirmar.addEventListener('click', function (e) {
    e.preventDefault();
    
        const infoHab = new FormData(infoVehiculo);
        fetch('../backend/consultaHuesped.php', {
            method:'POST',
            body: infoHab
        })
        .then(function(response){
            if(response.ok) {
                return response.text();
            } else {
                throw "Error en la llamada Ajax";
            }
        })
        .then(function(texto) {
            if (texto == '0') {
                alert("La habitacion no está ocupada o no existe");
                btnConfirmar.disabled = true;
                
            }
            else{
                cargarTabla();
            }
         })
         .catch(function(err) {
            console.log(err);
         });
});