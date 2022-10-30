const canvas = document.getElementById('grafica');
const fecha = document.getElementById('selectorFecha');
const opciones = document.getElementById('seleccionReporte');
const diario = document.getElementById('btnDiario');
const semanal = document.getElementById('btnSemanal');
const mensual = document.getElementById('btnMensual');
const anual = document.getElementById('btnAnual');
const graficaLinea = document.getElementById('btnLinea');
const graficaCircular = document.getElementById('btnCircular');
const divBotones = document.querySelector('.botonesTiempo');
const divBotonesGraficas = document.querySelector('.botonesGraficas');
const divBotonesPreguntas = document.querySelector('.botonesPreguntas');
const h3Pregunta = document.querySelector('.pregunta');
const btnsPreguntas = document.querySelectorAll('.btnPregunta');
const apartadoPreguntas = document.querySelector('.apartadoPreguntas');
const apartadoHabs = document.querySelector('.apartadoTiposHabs');
const btnGeneracionPDF = document.querySelector('.descargaPdf');
var labelY = "";
var labelX = "";
var diasReporte = 1;
var labels = [];
var grafica;
var hotel = "";
var StringTipoHabsDoc = "";
const dias = [
  'domingo',
  'lunes',
  'martes',
  'miércoles',
  'jueves',
  'viernes',
  'sábado',
];
const meses = [
  'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
  'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
];

var numPregunta = 1;
const fragment = document.createDocumentFragment();

const infoReporte = new FormData();



fecha.addEventListener('change', (e) => {
  e.preventDefault();
  console.log(fecha.value);
  generarGrafica();

})

diario.addEventListener('click', () => {
  diasReporte = 1;
  diario.classList.add('active');
  semanal.classList.remove('active');
  mensual.classList.remove('active');
  anual.classList.remove('active');

  generarGrafica();
})

semanal.addEventListener('click', () => {
  diasReporte = 7;
  diario.classList.remove('active');
  semanal.classList.add('active');
  mensual.classList.remove('active');
  anual.classList.remove('active');

  generarGrafica();

})

mensual.addEventListener('click', () => {
  diasReporte = 30;
  diario.classList.remove('active');
  semanal.classList.remove('active');
  mensual.classList.add('active');
  anual.classList.remove('active');

  generarGrafica();
})

anual.addEventListener('click', () => {
  diasReporte = 365;
  diario.classList.remove('active');
  semanal.classList.remove('active');
  mensual.classList.remove('active');
  anual.classList.add('active');

  generarGrafica();

})

function obtenerLabelsHoras() {
  labels.push("0-4 horas");
  labels.push("5-8 horas");
  labels.push("9-12 horas");
  labels.push("13-16 horas");
  labels.push("17-20 horas");
  labels.push("21-24 horas");

}

function obtenerLabelsDias() {
  var inicio = new Date(fecha.value + " 00:00:00");
  var fin = new Date(fecha.value + " 00:00:00");
  fin.setDate(fin.getDate() + 7);
  console.log("El reporte inicia el " + inicio);
  console.log("El reporte termina el " + fin);
  const UN_DIA_EN_MILISEGUNDOS = 1000 * 60 * 60 * 24;
  const INTERVALO = UN_DIA_EN_MILISEGUNDOS; // Cada semana

  for (let i = inicio; i <= fin; i = new Date(i.getTime() + INTERVALO)) {

    var numeroDia = new Date(i).getDay();
    var nombreDia = dias[numeroDia] + " " + i.getDate();

    labels.push(nombreDia);
  }
}

function obtenerLabelsSemanas() {
  var inicio = new Date(fecha.value + " 00:00:00");
  var fechaAux = new Date(fecha.value + " 00:00:00");;
  fechaAux.setDate(fechaAux.getDate + 25);
  labels.push("6 dias (" + inicio.getDate() + "-" + (inicio.getDate() + 6) + ")");
  labels.push("12 dias (" + (inicio.getDate() + 7) + "-" + (inicio.getDate() + 12) + ")");
  labels.push("18 dias (" + (inicio.getDate() + 13) + "-" + (inicio.getDate() + 18) + ")");
  labels.push("14 dias (" + (inicio.getDate() + 19) + "-" + (inicio.getDate() + 24) + ")");
  labels.push("30 dias (" + (inicio.getDate() + 25) + "-" + (inicio.getDate() + 30) + ")");
}

function obtenerLabelsMeses() {
  const inicioMeses = new Date(fecha.value + " 00:00:00");
  const finMeses = new Date(fecha.value + " 00:00:00");
  finMeses.setFullYear(finMeses.getFullYear() + 1)

  for (let i = inicioMeses; i <= finMeses; i.setMonth(i.getMonth() + 1)) {
    var numeroMes = new Date(i).getMonth();
    var nombreMes = meses[numeroMes];
    labels.push(nombreMes);
  }
}




opciones.addEventListener('change', (e) => {
  e.preventDefault();
  generarGrafica();
})

function generarGrafica() {
  divBotones.classList.remove('oculto');
  apartadoPreguntas.classList.add('oculto');
  labels = [];
  var stringCondicionHabs = obtenerCondicionalHabs();
  if (fecha.value != '' && opciones.value != '0') {
    if (diasReporte == 1) {
      obtenerLabelsHoras();
    } else if (diasReporte == 7) {
      obtenerLabelsDias();
    } else if (diasReporte == 30) {
      obtenerLabelsSemanas();
    } else if (diasReporte == 365) {
      obtenerLabelsMeses();
    }

    switch (opciones.value) {

      case '1': //Ingresos por estancia
        infoReporte.append('fechaInicio', fecha.value);
        infoReporte.append('dias', diasReporte);
        infoReporte.append('habs', stringCondicionHabs);
        labelY = "Dinero";
        labelX = "Tiempo";
        obtenerIngresosEstancia();

        break;

      case '2':  //Ingresos de servicios  
        infoReporte.append('fechaInicio', fecha.value);
        infoReporte.append('dias', diasReporte);
        infoReporte.append('habs', stringCondicionHabs);
        labelY = "Dinero";
        labelX = "Tiempo";
        obtenerIngresosServicios();
        break;

      case '3':

        break
      case '5':
        console.log("Se entró a num de limpiezas");
        infoReporte.append('fechaInicio', fecha.value);
        infoReporte.append('dias', diasReporte);
        infoReporte.append('habs', stringCondicionHabs);
        labelY = "Numero de limpiezas";
        labelX = "Tiempo";
        obtenerNumeroLimpiezas();
        break;
      case '6':

        infoReporte.append('fechaInicio', fecha.value);
        infoReporte.append('dias', diasReporte);
        infoReporte.append('habs', stringCondicionHabs);
        labelY = "Numero de ocupaciones";
        labelX = "Tiempo";
        obtenerNumeroOcupaciones();
        break;
      case '7':

        infoReporte.append('fechaInicio', fecha.value);
        infoReporte.append('dias', diasReporte);
        infoReporte.append('habs', stringCondicionHabs);
        labelY = "Numero de desocupaciones";
        labelX = "Tiempo";
        obtenerNumeroDesocupaciones();
        break;
      case '8':

        infoReporte.append('fechaInicio', fecha.value);
        infoReporte.append('dias', diasReporte);
        infoReporte.append('habs', stringCondicionHabs);
        labelY = "Dinero";
        labelX = "Tiempo";
        obtenerIngresosTotales();
        break;
      case '9':
        divBotones.classList.add('oculto');
        obtenerProductosServicios();
        break;
      case '10':
        divBotones.classList.add('oculto');
        infoReporte.append('habs', stringCondicionHabs);
        obtenerTiempoOcupaciones();
        break;
      case '10':
        divBotones.classList.add('oculto');
        infoReporte.append('habs', stringCondicionHabs);
        obtenerTiempoOcupaciones();
        break;
      case '11':
          divBotones.classList.add('oculto');
          obtenerCategoriasReportes();
          break;
      case '12':
          divBotones.classList.add('oculto');
          infoReporte.append('habs', stringCondicionHabs);
          obtenerTiempoReportes();
          break;
      case '13':
        apartadoPreguntas.classList.remove('oculto');
        infoReporte.append('fechaInicio', fecha.value);
        infoReporte.append('dias', diasReporte);
        infoReporte.append('numPregunta', numPregunta);
        infoReporte.append('habs', stringCondicionHabs);
        labelY = "Promedio de calificación";
        labelX = "Tiempo";
        obtenerRespuestasEncuestaSalida();
        break;
    }
  } else {
    console.log("no");
  }
}

function generarGraficaLineal(labels, datos) {
  grafica.destroy();
  console.log(datos);
  grafica = new Chart(canvas, {
    type: "line",
    data: {
      labels: labels,
      datasets: [{
        label: "Datos",
        backgroundColor: 'rgba(89,17,77,1.0)',
        borderColor: 'rgba(89,17,77,0.65)',

        data: datos
      }]
    },
    options: {
      legend: { display: false },
      scales: {

        y: {
          title: {
            display: true,
            text: labelY,

          }
        },
        x: {
          title: {
            display: true,
            text: labelX
          }
        }

      }
    },

  })
}

function generarGraficaLinealOpciones(labels, datos, opciones) {
  grafica.destroy();
  console.log(datos);
  grafica = new Chart(canvas, {
    type: "line",
    data: {
      labels: labels,
      datasets: [{
        label: "Pregunta",
        backgroundColor: 'rgba(89,17,77,1.0)',
        borderColor: 'rgba(89,17,77,0.65)',

        data: datos
      }]
    },
    options: opciones
  })
}

function generarGraficaPolar(labelsProductos, datos) {
  grafica.destroy();
  grafica = new Chart(canvas, {
    type: "polarArea",
    data: {
      labels: labelsProductos,
      datasets: [{
        label: "Semanal",
        data: datos
      }]
    }
  })

}

function obtenerCategoriasReportes(){
  fetch('../backendReportesSistema/obtenerCategoriasReportes.php', {
    method: 'POST'
  }).then(function (response) {
    if (response.ok) {
      return response.json();
    } else {
      throw "Error en la llamada Ajax"
    }
  }).then(function (info) {
    console.log(info);
    cat = [];
    numProds = [];
    categorias = [cat, numProds];
    for (element of info) {
      if (cat.indexOf(element.CatReporte_Nombre) == -1) {
        cat.push(element.CatReporte_Nombre);
        posicion = cat.indexOf(element.CatReporte_Nombre);
        numProds[posicion] = 1;

      } else {
        posicion = cat.indexOf(element.CatReporte_Nombre);
        numProds[posicion] += 1;
      }
    }
    generarGraficaPolar(cat, numProds);
  })
}



function obtenerIngresosEstancia() {
  fetch('../backendReportesSistema/ingresosPorEstancia.php', {
    method: 'POST', body: infoReporte
  }).then(function (response) {
    if (response.ok) {
      return response.json();
    } else {
      throw "Error en la llamada Ajax"
    }
  }).then(function (info) {
    generarGraficaLineal(labels, info);


  })
}

function obtenerIngresosServicios() {
  fetch('../backendReportesSistema/obtenerIngresosGeneralesServicio.php', {
    method: 'POST', body: infoReporte
  }).then(function (response) {
    if (response.ok) {
      return response.json();
    } else {
      throw "Error en la llamada Ajax"
    }
  }).then(function (info) {
    console.log(info);
    generarGraficaLineal(labels, info);

  })
}

function obtenerNumeroLimpiezas() {
  fetch('../backendReportesSistema/obtenerNumeroLimpiezas.php', {
    method: 'POST', body: infoReporte
  }).then(function (response) {
    if (response.ok) {
      return response.json();
    } else {
      throw "Error en la llamada Ajax"
    }
  }).then(function (info) {
    console.log(info);
    generarGraficaLineal(labels, info);

  })
}

function obtenerNumeroOcupaciones() {
  fetch('../backendReportesSistema/obtenerNumeroOcupaciones.php', {
    method: 'POST', body: infoReporte
  }).then(function (response) {
    if (response.ok) {
      return response.json();
    } else {
      throw "Error en la llamada Ajax"
    }
  }).then(function (info) {
    console.log(info);
    generarGraficaLineal(labels, info);

  })
}

function obtenerNumeroDesocupaciones() {
  fetch('../backendReportesSistema/obtenerNumeroDesocupaciones.php', {
    method: 'POST', body: infoReporte
  }).then(function (response) {
    if (response.ok) {
      return response.json();
    } else {
      throw "Error en la llamada Ajax"
    }
  }).then(function (info) {
    console.log(info);
    generarGraficaLineal(labels, info);

  })
}

function obtenerIngresosTotales() {
  fetch('../backendReportesSistema/obtenerIngresosTotales.php', {
    method: 'POST', body: infoReporte
  }).then(function (response) {
    if (response.ok) {
      return response.json();
    } else {
      throw "Error en la llamada Ajax"
    }
  }).then(function (info) {
    console.log(info);
    generarGraficaLineal(labels, info);

  })
}

function obtenerProductosServicios() {
  fetch('../backendReportesSistema/obtenerProductos.php', {
    method: 'POST'
  }).then(function (response) {
    if (response.ok) {
      return response.json();
    } else {
      throw "Error en la llamada Ajax"
    }
  }).then(function (info) {
    console.log(info);
    cat = [];
    numProds = [];
    categorias = [cat, numProds];
    for (element of info) {
      console.log(element.CatProd_Categoria)
      if (cat.indexOf(element.CatProd_Categoria) == -1) {
        cat.push(element.CatProd_Categoria);
        posicion = cat.indexOf(element.CatProd_Categoria);
        numProds[posicion] = 1;

      } else {
        posicion = cat.indexOf(element.CatProd_Categoria);
        numProds[posicion] += 1;
      }
    }
    generarGraficaPolar(cat, numProds);
  })
}

function obtenerTiempoOcupaciones() {
  fetch('../backendReportesSistema/obtenerTiempoOcupaciones.php', {
    method: 'POST', body: infoReporte
  }).then(function (response) {
    if (response.ok) {
      return response.json();
    } else {
      throw "Error en la llamada Ajax"
    }
  }).then(function (info) {
    console.log(info);
    labels = [];
    labels.push("1 a 2 días");
    labels.push("3 a 4 días");
    labels.push("5 a 6 días");
    labels.push("7 a 8 días");
    labels.push("9 a 10 días");
    labels.push("11 a 12 días");
    labels.push("1 2a 14 días");
    generarGraficaPolar(labels, info);
  })
}

function obtenerTiempoReportes() {
  fetch('../backendReportesSistema/tiempoRespuestaReportes.php', {
    method: 'POST', body: infoReporte
  }).then(function (response) {
    if (response.ok) {
      return response.json();
    } else {
      throw "Error en la llamada Ajax"
    }
  }).then(function (info) {
    console.log(info);
    labels = [];
    labels.push("0 a 5 minutos");
    labels.push("5 a 10 minutos");
    labels.push("10 a 15 minutos");
    labels.push("15 a 20 minutos");
    labels.push("20 a 25 minutos");
    labels.push("25 a 30 minutos");
    labels.push("+30 minutos");
    generarGraficaPolar(labels, info);
  })
}


function obtenerRespuestasEncuestaSalida() {
  fetch('../backendReportesSistema/obtenerEncuestaSalida.php', {
    method: 'POST', body: infoReporte
  }).then(function (response) {
    if (response.ok) {
      return response.json();
    } else {
      throw "Error en la llamada Ajax"
    }
  }).then(function (info) {
    console.log(info);
    let opciones = {

      scales: {
        y: {
          title: {
            display: true,
            text: labelY
          },
          max: 5,
          min: 0,
          ticks: {
            stepSize: 1
          }

        },
        x: {
          title: {
            display: true,
            text: labelX
          }

        }
      }


    };
    generarGraficaLinealOpciones(labels, info, opciones);

  })
}

window.addEventListener('load', () => {
  fecha.value = new Date().toISOString().slice(0, 10);
  grafica = new Chart(canvas);
  definirInfoPregunta(numPregunta);
  cargarTiposHabs();
  obtenerNombreHotel();

})

divBotonesPreguntas.addEventListener('click', e => {
  console.log(e);
  if (e.target.classList.contains('btnPregunta')) {
    var idPregunta = e.target.id;
    definirInfoPregunta(idPregunta);
    generarGrafica();
  }
})



apartadoHabs.addEventListener('click', e => {
  console.log(e);

  if (e.target.classList.contains('checkboxHab')) {
    generarGrafica();
  }
})

function definirInfoPregunta(id) {
  var infoPregunta = ["Calificación del servicio de limpieza", "Calificación del servicio a la habitación",
    "calificación del servicio de recepción", "Calificación del servicio de valet",
    "Calificación de la atención general", "Calificación de la calidad de las instalaciones",
    "Caliicación de la limpieza de áreas comunes", "Calificación del seguimiento de reportes",
    "Calificación de la atención del chatbot", "Calificación de la velocidad de atención"]
  console.log(infoPregunta[id - 1]);
  h3Pregunta.textContent = infoPregunta[id - 1];
  numPregunta = id;

  for (element of btnsPreguntas) {
    if (id == element.id) {
      element.classList.add('active');
    } else {
      element.classList.remove('active');
    }
  }

}

function cargarTiposHabs() {
  this.preventDefault;
  fetch('../backendReportesSistema/obtenerTiposDeHabs.php', {
    method: 'POST'
  }).then(function (response) {
    if (response.ok) {
      return response.json();
    } else {
      throw "Error en la llamada Ajax"
    }
  }).then(function (texto) {
    for (element of texto) {  //Por cada elemento del json
      console.log(texto);
      var checkboxHab = document.createElement('input');
      checkboxHab.setAttribute('type', "checkbox");
      checkboxHab.id = element.tipohab_ID;
      checkboxHab.value = element.tipohab_nombre;
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

function obtenerCondicionalHabs() {
  StringTipoHabsDoc = "";
  let checkboxes = document.querySelectorAll('.checkboxHab');
  console.log(checkboxes);
  var stringCondicion = "";
  var contadorHabs = 0;
  for (element of checkboxes) {
    if (!element.checked) {
      stringCondicion += " AND tipohabitacion.TipoHab_ID != " + element.id;
    } else {
      StringTipoHabsDoc += "-" + element.value + "\r";  
      contadorHabs++;
    }
  }
  if(contadorHabs == checkboxes.length){
    StringTipoHabsDoc += " \rSe tomaron en cuenta todas las habitaciones del hotel."
  }
  console.log(stringCondicion);
  return stringCondicion;
  var perido;
}

btnGeneracionPDF.addEventListener('click', () => {
  var inicio = new Date(fecha.value + " 00:00:00");
  var fin = new Date(fecha.value + " 00:00:00");
  if (diasReporte == 1) {
    fin.setDate(fin.getDate() + 1);
    periodo = "diario";
  }
  else if (diasReporte == 7) {
    fin.setDate(fin.getDate() + 7);
    periodo = "semanal";
  }
  else if (diasReporte == 30) {
    fin.setMonth(fin.getMonth() + 1);
    periodo = "mensual";
  }
  else if (diasReporte == 365) {
    fin.setFullYear(fin.getFullYear() + 1);
    periodo = "anual";
  }

  var inicioConFormato = dias[inicio.getDay()] + ', '
    + inicio.getDate() + ' de ' + meses[inicio.getMonth()]
    + ' de ' + inicio.getUTCFullYear();

  var finConFormato = dias[fin.getDay()] + ', '
    + fin.getDate() + ' de ' + meses[fin.getMonth()]
    + ' de ' + fin.getUTCFullYear();


  console.log("Se está generando el pdf");
  var doc = new jsPDF();
  
  doc.setFontType('bold');

  var logo = new Image();
  logo.src = "../../../Recursos/LogoBT.png";
  logo.onload = function () {
    doc.addImage(logo, "PNG", 180, 5, 15, 15);
    console.log("aaaaaa")
    doc.setFont('helvetica');
    //doc.setTextColor(89, 17, 77);
    doc.text('Reporte de ' + opciones.options[opciones.selectedIndex].text, 110, 30, "center");
    doc.text(hotel, 15, 15);
    doc.setTextColor(0, 0, 0);
    doc.setFontSize(12);
    
    doc.setFontType('normal');
    context = canvas.getContext("2d");
    var imgData = canvas.toDataURL('image/png');

    doc.addImage(imgData, 'PNG', 10, 100, 170, 110);

    doc.text("El periodo del reporte será del \r" + inicioConFormato + " al \r" + finConFormato +
      ", \rsiendo de tipo " + periodo + ". \r\rEste reporte tomará en cuenta las habitaciones: \r" +
      StringTipoHabsDoc, 20, 50);

    window.open(doc.output('bloburl'))
  }
})

function obtenerNombreHotel(){
  fetch('../backendReportesSistema/obtenerNombreHotel.php', {
    method: 'POST', body: infoReporte
  }).then(function (response) {
    if (response.ok) {
      return response.json();
    } else {
      throw "Error en la llamada Ajax"
    }
  }).then(function (hotelNombre) {
    console.log(hotelNombre);
    for(item of hotelNombre){
      hotel = item.Hotel_Nombre;
    }


  })
}