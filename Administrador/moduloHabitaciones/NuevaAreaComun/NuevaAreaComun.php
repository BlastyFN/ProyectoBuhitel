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
    <link rel="stylesheet" href="NuevaAreaComun.css">
    <? include('../../../Recursos/includeHead.php') ?>
    <title>Nueva Área Común</title>
</head>
<body>
    
    <section id="header-menu" class="header-menu">

    </section>

    <h1>
        Ingrese la información de la nueva área común
    </h1>
    <section class="contFormulario">
        <form class="ingresarTipoForm" action="" method="post">
            <input type="text" class="formText" id="nombreTipo" placeholder="Nombre del área común">
            <br>
            <select name="piso" id="piso" class="formText">
            <option selected="true" disabled>Piso</option>
            </select>
            <br>
            <div class="">
                <h2 class="CentrarTexto">Habitaciones</h2>
                <br>
                <div id="contenedorDatosLimpiezas">
                
                </div>
                <button class="agregarLimpieza" id="agregarLimpieza" disabled>Añadir dia</button>
            </div>
    
            <button type="submit" class="enviarInfo">Aceptar</button>
        </form>
        
    </section>
    


    <script src="../../../Recursos/clase-menu.js"></script>
    
    <script src="../../../Recursos/menuTransition.js"></script>
    <script src="NuevaAreaComun.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <? include('../../../Recursos/includeScripts.php') ?>

</body>
</html>