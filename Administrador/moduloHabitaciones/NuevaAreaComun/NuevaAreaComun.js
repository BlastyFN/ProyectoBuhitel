const ingresarTipoForm = document.querySelector('.ingresarTipoForm');
console.log(ingresarTipoForm);
const enviarTipo = new FormData();
const inputNombreTipo = document.getElementById('nombreTipo');
const inputPrecio = document.getElementById('precioTipo');
const inputNumCamas = document.getElementById('numCamas');
const inputLimpNormal = document.getElementById('tiempoLimpNormal');
const inputLimpProf = document.getElementById('tiempoLimpProf');
const btnAgregarLimpieza = document.getElementById('agregarLimpieza');
const divDatosLimpiezas = document.getElementById('contenedorDatosLimpiezas');
const valueLimpNormal = inputLimpNormal.value;
const fragment = document.createDocumentFragment();
console.log(valueLimpNormal);
const diasSemana = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo']


btnAgregarLimpieza.addEventListener('click', (e) => {
    const selectDias = document.createElement('select');
    diasSemana.forEach(dia => {
        const optionDia = document.createElement('option');
        optionDia.setAttribute('value',dia);
        optionDia.textContent = dia;
        selectDias.appendChild(optionDia);
    });
    
    fragment.appendChild(selectDias);

    const horaInicio = document.createElement('input');
    horaInicio.setAttribute('type','date');
    const horaFin = document.createElement('input');
    horaFin.setAttribute('type','date');

    fragment.appendChild(horaInicio);
    fragment.appendChild(horaFin);
    divDatosLimpiezas.appendChild(fragment);
})


ingresarTipoForm.addEventListener('submit', function(e){
    e.preventDefault();
    var valorNombre = inputNombreTipo.value;
    enviarTipo.append('nombre',valorNombre);
    var valorPrecio = inputPrecio.value;
    enviarTipo.append('precio',valorPrecio);
    var valorNumCamas = inputNumCamas.value;
    enviarTipo.append('numCamas',valorNumCamas);
    var valueLimpNormal = inputLimpNormal.value;
    enviarTipo.append('limpNormal',valueLimpNormal);
    var ValorLimpProf = inputLimpProf.value;
    enviarTipo.append('limpProf',ValorLimpProf);
   
    

    fetch('../backend/registrarTipoHab.php' , {
        method:'POST', body:enviarTipo
    }).then(function(response){
        if(response.ok){
         return response.text();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(texto){
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'El tipo de habitación se ha registrado correctamente',
            showConfirmButton: false,
            timer: 2500
        }).then(()=>{
            window.location.href = "https://corporativotdo.com/Administrador/moduloHabitaciones/VistaGeneralHab/vistaGeneralHab.php";
        });
    })
});