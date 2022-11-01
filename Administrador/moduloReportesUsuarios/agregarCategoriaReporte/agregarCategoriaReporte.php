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
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <link rel="stylesheet" href="agregarCategoriaReporte.css">
    <title>Nueva categoria de reporte</title>
</head>
<body>
    <section id="header-menu" class="header-menu">

    </section>
        <h1>
            Agregue la nueva categoría de reporte y acomodela según la prioridad que quiera asignar 
        </h1>

    
        <input type="text" class="textForm" id="inputNombre" placeholder="Nueva categoría" maxlength="20" required>
        

        <div class="contenedorCats">
            <div class="wrapper">


            </div>

        </div>

        <button id="enviar" class="btnEnviar" disabled="true">Añadir</button>
    
        
        
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js" integrity="sha512-Eezs+g9Lq4TCCq0wae01s9PuNWzHYoCMkE97e2qdkYthpI0pzC3UGB03lgEHn2XM85hDOUF6qgqqszs+iXU4UA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="agregarCategoriaReporte.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    <? include('../../../Recursos/includeScripts.php') ?>
    
</body>
</html>