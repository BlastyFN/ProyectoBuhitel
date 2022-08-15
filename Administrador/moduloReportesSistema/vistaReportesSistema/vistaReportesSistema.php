<?php 
session_start();
//if ($_SESSION['sesionPersonal']['Tipo']!='Administrador') {
 //           header("Location: /index.php", TRUE, 301);
//}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../recursos/estilos-menu.css">
    <link rel="stylesheet" href="vistaReportesSistema.css">
    <title>Registro de nuevo usuario</title>
</head>
<body>
    <section id="header-menu" class="header-menu">

    </section>
        <h1>
            Introduzca la fecha y el tipo de reporte, así como el periodo de tiempo del reporte 
        </h1>

        
            <input type="date" class="formText" id="selectorFecha">
        
    
        <select name="seleccionReporte" id="seleccionReporte" class="formText">
            <option selected="true" value="0" disabled>Seleccione un reporte</option>
            <option value="1">Ingresos por estancia</option>
            <option value="2">Ingresos generales de servicios</option>
            
            <option value="5">Numero de limpiezas realizadas</option>
            <option value="6">Numero de ocupaciones</option>
            <option value="7">Numero de desocupaciones</option>
            <option value="8">Ingresos totales</option>
            <option value="9">Productos y servicios</option>
            <option value="10">Duracion de ocupaciones</option>
            <option value="11">Ingresos totales</option>
            <option value="12">Ingresos totales</option>
            <option value="13">Encuesta de salida</option>               
        </select>

        <div class="botonesTiempo">
            <button class="btnTiempo active" id="btnDiario">Diario</button>
            <button class="btnTiempo" id="btnSemanal">Semanal</button>
            <button class="btnTiempo" id="btnMensual">Mensual</button>
            <button class="btnTiempo" id="btnAnual">Anual</button>
        </div>
        <div class="chart-container" >
            <canvas id="grafica"></canvas>
        </div>
        
    </section>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
    <script src="vistaReportesSistema.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>

    
</body>
</html>