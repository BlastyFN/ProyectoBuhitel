<?php 
session_start();
if ($_SESSION['sesionPersonal']['Tipo']!='Administrador') {
            header("Location: /index.php", TRUE, 301);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <link rel="stylesheet" href="modificacionTipoHab.css">
    <? include('../../../Recursos/includeHead.php') ?>
    <title>Nuevo tipo de habitacion</title>
</head>
<body>
    
    <section id="header-menu" class="header-menu">

    </section>

    <h1>
        Seleccione el tipo a modificar y cambie la información de la  habitación
    </h1>
    <section class="contFormulario">
        <form class="ingresarTipoForm"  method="post">
            <select name="tipoHabs" id="opcDesplegable" class="formText">

                
            </select>
            <br>
            <br>
            <input type="text" class="formText" id="nombreTipo" placeholder="Nombre del nuevo tipo de habitación">
            <br>
            <input type="number" class="formText" id="precioTipo" placeholder="Precio por noche">
            <br>
            <input type="number" class="formText" id="numCamas" placeholder="Número de camas">
            <br>
            <input type="time" class="formText" id="tiempoLimpNormal" placeholder="Tiempo estimado de limpieza normal">
            <br>    
            <input type="time" class="formText" id="tiempoLimpProf" placeholder="Tiempo estimado de limpieza profunda">
            <br>
    
            <button type="submit" class="enviarInfo">Aceptar</button>
        </form>
        
    </section>
    


    <script src="../../../Recursos/clase-menu.js"></script>    
    <script src="../../../Recursos/menuTransition.js"></script>
    <script src="modificarTipoHab.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <? include('../../../Recursos/includeScripts.php') ?>
</body>
</html>