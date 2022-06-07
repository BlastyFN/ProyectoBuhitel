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
            Ingrese la información del nuevo usuario 
        </h1>
    
        <select name="seleccionReporte" id="seleccionReporte" class="formText">
            <option selected="true" disabled>Seleccione un reporte</option>
            <option value="1">Ingresos por estancia</option>
            <option value="2">Ingresos generales de servicios</option>
            <option value="3">Ingresos de servicio por categoría de productos</option>
            <option value="4">Personal de servicio</option>               
        </select>

        <canvas id="grafica"></canvas>

        
    </section>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
    <script src="vistaReportesSistema.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>

    
</body>
</html>