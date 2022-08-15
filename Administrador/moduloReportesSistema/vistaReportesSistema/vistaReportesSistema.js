const canvas = document.getElementById('grafica');
const fecha = document.getElementById('selectorFecha');
const opciones = document.getElementById('seleccionReporte')
const diario = document.getElementById('btnDiario');
const semanal = document.getElementById('btnSemanal');
const mensual = document.getElementById('btnMensual');
const anual = document.getElementById('btnAnual');
var diasReporte = 1;
var labels = [];
var grafica;

const infoReporte = new FormData();



fecha.addEventListener('change', (e)=>{
  e.preventDefault();
  console.log(fecha.value);
  generarGrafica();
    
})

diario.addEventListener('click', ()=>{
  diasReporte = 1;
  diario.classList.add('active');
  semanal.classList.remove('active');
  mensual.classList.remove('active');
  anual.classList.remove('active');
  
  generarGrafica();
})

semanal.addEventListener('click', ()=>{
  diasReporte = 7;
  diario.classList.remove('active');
  semanal.classList.add('active');
  mensual.classList.remove('active');
  anual.classList.remove('active');

  generarGrafica();
   
})

mensual.addEventListener('click', ()=>{
  diasReporte = 30;
  diario.classList.remove('active');
  semanal.classList.remove('active');
  mensual.classList.add('active');
  anual.classList.remove('active');
  
  generarGrafica();
})

anual.addEventListener('click', ()=>{
  diasReporte = 365;
  diario.classList.remove('active');
  semanal.classList.remove('active');
  mensual.classList.remove('active');
  anual.classList.add('active');

  generarGrafica();

})

function obtenerLabelsHoras(){
  labels.push("0-4 horas" );
  labels.push("5-8 horas" );
  labels.push("9-12 horas" );
  labels.push("13-16 horas" );
  labels.push("17-20 horas" );
  labels.push("21-24 horas" );

}

function obtenerLabelsDias(){
  var inicio = new Date(fecha.value + " 00:00:00");
  var fin = new Date(fecha.value + " 00:00:00");
  fin.setDate(fin.getDate()+7);
  console.log("El reporte inicia el " + inicio);
  console.log("El reporte termina el " + fin);
  const UN_DIA_EN_MILISEGUNDOS = 1000 * 60 * 60 * 24;
  const INTERVALO = UN_DIA_EN_MILISEGUNDOS; // Cada semana

  for (let i = inicio; i <= fin; i = new Date(i.getTime() + INTERVALO)) {
    const dias = [
      'domingo',
      'lunes',
      'martes',
      'miércoles',
      'jueves',
      'viernes',
      'sábado',
    ];
    var numeroDia = new Date(i).getDay();
    var nombreDia = dias[numeroDia] + " " + i.getDate();

    labels.push(nombreDia);
  }
}

function obtenerLabelsSemanas(){
  var inicio = new Date(fecha.value + " 00:00:00");
  var fechaAux = inicio;
  fechaAux.setDate(fechaAux.getDate + 25);
  labels.push("6 dias (" + inicio.getDate() + "-"+(inicio.getDate()+6) + ")" );
  labels.push("12 dias (" + (inicio.getDate() + 7) + "-"+(inicio.getDate()+12) + ")" );
  labels.push("18 dias (" + (inicio.getDate() + 13) + "-"+(inicio.getDate()+18) + ")" );
  labels.push("14 dias (" + (inicio.getDate() + 19) + "-"+(inicio.getDate()+24) + ")" );
  labels.push("30 dias (" + (inicio.getDate() + 25) + "-"+(inicio.getDate()+30) + ")" );
}

function obtenerLabelsMeses(){
  const inicioMeses = new Date(fecha.value + " 00:00:00");
  const finMeses = new Date(fecha.value + " 00:00:00");
  finMeses.setFullYear(finMeses.getFullYear() + 1)

  for (let i = inicioMeses; i <= finMeses; i.setMonth(i.getMonth() + 1)) {
    
      const meses = [
        'Enero','Febrero','Marzo','Abril','Mayo','Junio',
        'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
      ];
      var numeroMes = new Date(i).getMonth();
      var nombreMes = meses[numeroMes];
      labels.push(nombreMes);
    }
}




  opciones.addEventListener('change', (e)=>{
    e.preventDefault();
    generarGrafica();
  })

  function generarGrafica(){
    labels = [];
    if(fecha.value!='' && opciones.value!='0'){  
      if(diasReporte==1){
        obtenerLabelsHoras();
      } else if(diasReporte==7){
        obtenerLabelsDias();
      } else if(diasReporte==30){
        obtenerLabelsSemanas();
      } else if(diasReporte==365){
        obtenerLabelsMeses();
      }
      grafica.destroy();
      switch(opciones.value){
        
        case '1': //Ingresos por estancia
        console.log("Se entró a ingresos por estancia");
          infoReporte.append('fechaInicio', fecha.value);
          infoReporte.append('dias', diasReporte);
          obtenerIngresosEstancia();
          
          break;

        case '2':  //Ingresos de servicios
        console.log("Se entró a ing por servicios");
          infoReporte.append('fechaInicio', fecha.value);
          infoReporte.append('dias', diasReporte);
          obtenerIngresosServicios();  
          break;
        
        case '3':

          break
        case '5':
          console.log("Se entró a num de limpiezas");
          infoReporte.append('fechaInicio', fecha.value);
          infoReporte.append('dias', diasReporte);
          obtenerNumeroLimpiezas();
          break;
        case '6':
          infoReporte.append('fechaInicio', fecha.value);
          infoReporte.append('dias', diasReporte);
          obtenerNumeroOcupaciones();
          break;
        case '7':
          infoReporte.append('fechaInicio', fecha.value);
          infoReporte.append('dias', diasReporte);
          obtenerNumeroDesocupaciones();
          break;
        case '8':
          infoReporte.append('fechaInicio', fecha.value);
          infoReporte.append('dias', diasReporte);
          obtenerIngresosTotales();
          break;
        case '9':
          obtenerProductosServicios();
          break;
        case '10':
          obtenerTiempoOcupaciones();
          break;
      }
    }else{
      console.log("no");
    }
  }

  function generarGraficaPolar(labelsProductos,datos){

    grafica = new Chart (canvas, {
      type: "polarArea",
      data: {
        labels:labelsProductos,
        datasets: [{
          label: "Semanal",
          data:datos
        }]
      }
    })

  }

  function obtenerIngresosEstancia(){
   fetch('../backendReportesSistema/ingresosPorEstancia.php' , {
      method:'POST', body:infoReporte
    }).then(function(response){
      if(response.ok){
       return response.json();
      } else {
          throw "Error en la llamada Ajax"
      }
    }).then(function(info){
        console.log(info);
        grafica = new Chart (canvas, {
          type: "line",
          data: {
            labels:labels,
            datasets: [{
              label: "Semanal",
              data:info
            }]
          }
        })
        
        
    })
  }

  function obtenerIngresosServicios(){
    fetch('../backendReportesSistema/obtenerIngresosGeneralesServicio.php' , {
      method:'POST', body:infoReporte
    }).then(function(response){
      if(response.ok){
       return response.json();
      } else {
          throw "Error en la llamada Ajax"
      }
    }).then(function(info){
        console.log(info);
        grafica = new Chart (canvas, {
          type: "line",
          data: {
            labels:labels,
            datasets: [{
              label: "Semanal",
              data:info
            }]
          }
        })
        
    })
  }

  function obtenerNumeroLimpiezas(){
    fetch('../backendReportesSistema/obtenerNumeroLimpiezas.php' , {
      method:'POST', body:infoReporte
    }).then(function(response){
      if(response.ok){
       return response.json();
      } else {
          throw "Error en la llamada Ajax"
      }
    }).then(function(info){
        console.log(info);
        grafica = new Chart (canvas, {
          type: "line",
          data: {
            labels:labels,
            datasets: [{
              label: "Semanal",
              data:info
            }]
          }
        })
        
    })
  }

  function obtenerNumeroOcupaciones(){
    fetch('../backendReportesSistema/obtenerNumeroOcupaciones.php' , {
      method:'POST', body:infoReporte
    }).then(function(response){
      if(response.ok){
       return response.json();
      } else {
          throw "Error en la llamada Ajax"
      }
    }).then(function(info){
        console.log(info);
        grafica = new Chart (canvas, {
          type: "line",
          data: {
            labels:labels,
            datasets: [{
              label: "Semanal",
              data:info
            }]
          }
        })
        
    })
  }

  function obtenerNumeroDesocupaciones(){
    fetch('../backendReportesSistema/obtenerNumeroDesocupaciones.php' , {
      method:'POST', body:infoReporte
    }).then(function(response){
      if(response.ok){
       return response.json();
      } else {
          throw "Error en la llamada Ajax"
      }
    }).then(function(info){
        console.log(info);
        grafica = new Chart (canvas, {
          type: "line",
          data: {
            labels:labels,
            datasets: [{
              label: "Semanal",
              data:info
            }]
          }
        })
        
    })
  }

  function obtenerIngresosTotales(){
    fetch('../backendReportesSistema/obtenerIngresosTotales.php' , {
      method:'POST', body:infoReporte
    }).then(function(response){
      if(response.ok){
       return response.json();
      } else {
          throw "Error en la llamada Ajax"
      }
    }).then(function(info){
        console.log(info);
        grafica = new Chart (canvas, {
          type: "line",
          data: {
            labels:labels,
            datasets: [{
              label: "Semanal",
              data:info
            }]
          }
        })
        
    })
  }

  function obtenerProductosServicios(){
    fetch('../backendReportesSistema/obtenerProductos.php' , {
      method:'POST'
    }).then(function(response){
      if(response.ok){
       return response.json();
      } else {
          throw "Error en la llamada Ajax"
      }
    }).then(function(info){
        console.log(info);
        cat = [];
        numProds = [];
        categorias = [cat, numProds];
        for( element of info)
        {
          console.log(element.CatProd_Categoria)
          if(cat.indexOf(element.CatProd_Categoria)==-1){
            cat.push(element.CatProd_Categoria);
            posicion = cat.indexOf(element.CatProd_Categoria);
            numProds[posicion] = 1;
            
          } else {
            posicion = cat.indexOf(element.CatProd_Categoria);
            numProds[posicion] += 1;
          }
        }
        generarGraficaPolar(cat,numProds);
    })
  }

  function obtenerTiempoOcupaciones(){
    fetch('../backendReportesSistema/obtenerTiempoOcupaciones.php' , {
      method:'POST'
    }).then(function(response){
      if(response.ok){
       return response.json();
      } else {
          throw "Error en la llamada Ajax"
      }
    }).then(function(info){
        console.log(info);
        labels = [];
        labels.push("1 a 2 días");
        labels.push("3 a 4 días");
        labels.push("5 a 6 días");
        labels.push("7 a 8 días");
        labels.push("9 a 10 días");
        labels.push("11 a 12 días");
        labels.push("1 2a 14 días");
        generarGraficaPolar(labels,info);
    })
  }

   window.addEventListener('load', () =>{


       fecha.value = new Date().toISOString().slice(0, 10); 
       grafica = new Chart (canvas)
//     })
})


