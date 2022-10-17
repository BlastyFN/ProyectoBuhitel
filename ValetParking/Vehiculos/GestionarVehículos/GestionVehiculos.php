<?php 
session_start();
if ($_SESSION['sesionPersonal']['Tipo']!='Valet') {
            header("Location: /index.php", TRUE, 301);
}
else {
    # code...
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <? include('../../../Recursos/includeHead.php') ?>
    <title>Gestion Vehículos</title>
    <link rel="stylesheet" href="styleGestion.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
</head>
<body>
<section id="header-menu" class="header-menu" >

</section>
    <div id="Encabezado">
        <h2 class="CentrarTexto TituloPrincipal">Valet Parking</h1>
    </div>
    <br><br>

    <section id="ContenedorPrincipal">  
    </section>

    

    
    <script src= "JSGestionVehiculos.js"></script>
    <script src= "..\..\..\Recursos\jquery-3.6.0.min.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    <? include('../../../Recursos/notificaciones.js') ?>
</body>
</html>