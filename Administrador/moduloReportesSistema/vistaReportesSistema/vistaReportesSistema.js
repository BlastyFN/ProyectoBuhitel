const canvas = document.getElementById('grafica');
const fecha = document.getElementById('selectorFecha');
const opciones = document.getElementById('seleccionReporte')
const diario = document.getElementById('btnDiario');
const semanal = document.getElementById('btnSemanal');
const mensual = document.getElementById('btnMensual');
const anual = document.getElementById('btnAnual');
const divBotones = document.querySelector('.botonesTiempo');
const divBotonesPreguntas = document.querySelector('.botonesPreguntas');
const h3Pregunta = document.querySelector('.pregunta');
const btnsPreguntas = document.querySelectorAll('.btnPregunta');
const apartadoPreguntas = document.querySelector('.apartadoPreguntas');
const apartadoHabs = document.querySelector('.apartadoTiposHabs');
var diasReporte = 1;
var labels = [];
var grafica;
var numPregunta = 1;
const fragment = document.createDocumentFragment();

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
    divBotones.classList.remove('oculto');
    apartadoPreguntas.classList.add('oculto');
    labels = [];
    var stringCondicionHabs = obtenerCondicionalHabs(); 
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
      
      switch(opciones.value){
        
        case '1': //Ingresos por estancia
          infoReporte.append('fechaInicio', fecha.value);
          infoReporte.append('dias', diasReporte);
          infoReporte.append('habs', stringCondicionHabs);
          obtenerIngresosEstancia();
          
          break;

        case '2':  //Ingresos de servicios  
          infoReporte.append('fechaInicio', fecha.value);
          infoReporte.append('dias', diasReporte);
          infoReporte.append('habs', stringCondicionHabs);
          obtenerIngresosServicios();  
          break;
        
        case '3':

          break
        case '5':
          console.log("Se entró a num de limpiezas");
          infoReporte.append('fechaInicio', fecha.value);
          infoReporte.append('dias', diasReporte);
          infoReporte.append('habs', stringCondicionHabs);
          obtenerNumeroLimpiezas();
          break;
        case '6':
         
          infoReporte.append('fechaInicio', fecha.value);
          infoReporte.append('dias', diasReporte);
          infoReporte.append('habs', stringCondicionHabs);
          obtenerNumeroOcupaciones();
          break;
        case '7':
          
          infoReporte.append('fechaInicio', fecha.value);
          infoReporte.append('dias', diasReporte);
          infoReporte.append('habs', stringCondicionHabs);
          obtenerNumeroDesocupaciones();
          break;
        case '8':
         
          infoReporte.append('fechaInicio', fecha.value);
          infoReporte.append('dias', diasReporte);
          infoReporte.append('habs', stringCondicionHabs);
          obtenerIngresosTotales();
          break;
        case '9':
          divBotones.classList.add('oculto');
          obtenerProductosServicios();
          break;
        case '10':
          infoReporte.append('habs', stringCondicionHabs);
          obtenerTiempoOcupaciones();
          break;
        case '13':
          apartadoPreguntas.classList.remove('oculto');
          infoReporte.append('fechaInicio', fecha.value);
          infoReporte.append('dias', diasReporte);
          infoReporte.append('numPregunta', numPregunta);
          infoReporte.append('habs', stringCondicionHabs);
          obtenerRespuestasEncuestaSalida();
          break;
      }
    }else{
      console.log("no");
    }
  }

  function generarGraficaLineal(labels, datos){
    grafica.destroy();
    console.log(datos);
    grafica = new Chart (canvas, {
      type: "line",
      data: {
        labels:labels,
        datasets: [{
          backgroundColor: 'rgba(89,17,77,1.0)',
          borderColor: 'rgba(89,17,77,1.0)',
          pointBorderColor: 'rgba(89,17,77,1.0)',
          data:datos

        }]
      }
    })
  }

  function generarGraficaLineal(labels, datos, opciones){
    grafica.destroy();
    console.log(datos);
    grafica = new Chart (canvas, {
      type: "line",
      data: {
        labels:labels,
        datasets: [{
          backgroundColor: 'rgba(89,17,77,1.0)',
          borderColor: 'rgba(89,17,77,0.65)',
         
          data:datos
        }]
      },
      options:opciones
    })
  }

  function generarGraficaPolar(labelsProductos,datos){
    grafica.destroy();
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
      generarGraficaLineal(labels,info);
        
        
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
        generarGraficaLineal(labels,info);
        
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
        generarGraficaLineal(labels,info);
        
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
        generarGraficaLineal(labels,info);
        
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
        generarGraficaLineal(labels,info);
        
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
        generarGraficaLineal(labels,info);
        
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
      method:'POST', body:infoReporte
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

  function obtenerRespuestasEncuestaSalida(){
    fetch('../backendReportesSistema/obtenerEncuestaSalida.php' , {
      method:'POST', body: infoReporte
    }).then(function(response){
      if(response.ok){
       return response.json();
      } else {
          throw "Error en la llamada Ajax"
      }
    }).then(function(info){
        console.log(info); 
        let opciones = {
          scales: {
              y: {
                  max: 5,
                  min: 0,
                  ticks: {
                      stepSize: 1
                  }
              }
          }
      };
        generarGraficaLineal(labels,info,opciones);

    })   
  }

  window.addEventListener('load', () =>{
    fecha.value = new Date().toISOString().slice(0, 10); 
    grafica = new Chart (canvas);
    definirInfoPregunta(numPregunta);
    cargarTiposHabs();
  })

  divBotonesPreguntas.addEventListener('click', e =>{
    console.log(e);
    if(e.target.classList.contains('btnPregunta')){
        var idPregunta = e.target.id;
        definirInfoPregunta(idPregunta);
        generarGrafica();
    }
  })

  

   apartadoHabs.addEventListener('click', e =>{
    console.log(e);
  
    if(e.target.classList.contains('checkboxHab')){
      generarGrafica();
    }
  })

  function definirInfoPregunta(id){
    var infoPregunta = ["Calificación del servicio de limpieza","Calificación del servicio a la habitación",
    "calificación del servicio de recepción","Calificación del servicio de valet", 
    "Calificación de la atención general","Calificación de la calidad de las instalaciones",
    "Caliicación de la limpieza de áreas comunes","Calificación del seguimiento de reportes",
    "Calificación de la atención del chatbot","Calificación de la velocidad de atención"]
    console.log(infoPregunta[id-1]);
    h3Pregunta.textContent = infoPregunta[id-1];
    numPregunta = id;

    for(element of btnsPreguntas){
      if (id == element.id){
        element.classList.add('active');
      } else{
        element.classList.remove('active');  
      }
    }

  }

  function cargarTiposHabs(){
    this.preventDefault;
    fetch('../backendReportesSistema/obtenerTiposDeHabs.php' , {
        method:'POST'
    }).then(function(response){
        if(response.ok){
         return response.json();
        } else {
            throw "Error en la llamada Ajax"
        }
    }).then(function(texto){   
        for(element of texto){  //Por cada elemento del json
            console.log(texto);
            var checkboxHab = document.createElement('input');
            checkboxHab.setAttribute('type',"checkbox");
            checkboxHab.id = element.tipohab_ID;
            checkboxHab.checked = true;
            checkboxHab.classList.add('checkboxHab');

            var labelHab = document.createElement('label');
            labelHab.textContent = element.tipohab_nombre;
            
            fragment.appendChild(checkboxHab);
            fragment.appendChild(labelHab);
        }
        
        apartadoHabs.appendChild(fragment);
        
    });
}

function obtenerCondicionalHabs(){
  let checkboxes = document.querySelectorAll('.checkboxHab');
  console.log(checkboxes);
  var stringCondicion = "";
  for (element of checkboxes){
    if (!element.checked){
      stringCondicion += " AND tipohabitacion.TipoHab_ID != " + element.id;
    }
  }
  console.log(stringCondicion);
  return stringCondicion;
}

