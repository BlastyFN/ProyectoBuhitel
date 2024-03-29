<?php 
session_start();
if ($_SESSION['sesionPersonal']['Tipo']!='Recepcion') {
            header("Location: /index.php", TRUE, 301);
}
else {
    # code...
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styleServicios.css">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <? include('../../../Recursos/includeHead.php') ?>
    <title>Solicitar Limpieza</title>
</head>
<body>
<section id="header-menu" class="header-menu" >

</section>

    <h2 class="alinearTexto">Limpieza a la habitación</h2>
     <!-- Contenedor global -->
    <section class="">
        <!-- Mitad Izquierda -->
        <section class="Total">
            <br><br><br>
            
            <form action="" method="post" id="FormularioLimpieza">
                <input type="text" name="Habitacion" id="cmpHabitacion" placeholder="Habitación" class="CamposCentrados">
                <br><br>
                <input type="datetime-local" name="Fecha" id="cmpHora" class="CamposCentrados">
                <br><br>
                <button type="submit" class="Verde CamposCentrados ModelBtn" id="BtnVerificar">Solicitar</button>
            </form>
        </section>
        <!-- Mitad Izquierda -->
        <!-- Mitad Derecha -->
        <br><br><br>
        <section class="Mitad centrarMitad" id="ContenedorInfo">
            
            

        </section>
        <!-- Mitad Derecha -->
    </section>
    <!-- Contenedor global -->
    
</body>
<script src= "JSSolLimpieza.js"></script>
<script src="../../../Recursos/clase-menu.js"></script>
<script src="../../../Recursos/menuTransition.js"></script>
<? include('../../../Recursos/includeScripts.php') ?>
</html>