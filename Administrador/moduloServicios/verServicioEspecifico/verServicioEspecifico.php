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
    <link rel="stylesheet" href="verServicioEspecifico.css">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <? include('../../../Recursos/includeHead.php') ?>
    <title>Viendo información del servicio seleccionado</title>
</head>
<body>
    
    <section id="header-menu" class="header-menu">

    </section>

    <div class="main">
        <h1 class="titulo" id='<?php echo $simple; ?>' ></h1>
        <section class="infoPersonal">

            <p class="nombre"></p>
            <p class="tipo"></p>
            <p class="precio"></p>
            <p class="descripcion"></p>
            <p class="existencia"></p>
        </section>
        <section class="botones">
            <button class="boton volver">Volver</button>
            <button class="boton modificar">Modificar</button>
            <button class="boton eliminar">Eliminar</button>
        </section>
    </div>


    <script src="verServicioEspecifico.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>