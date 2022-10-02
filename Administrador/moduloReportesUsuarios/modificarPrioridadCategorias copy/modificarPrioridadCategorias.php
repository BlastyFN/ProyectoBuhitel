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
    <link rel="stylesheet" href="modificarPrioridadCategorias.css">
    <? include('../../../Recursos/includeHead.php') ?>
    <title>Nueva categoria de reporte</title>
</head>
<body>
    <section id="header-menu" class="header-menu">

    </section>
        <h1>
             
        </h1>

        

        <div class="contenedorCats">
            <div class="wrapper">


            </div>

        </div>

        <button id="enviar" class="btnEnviar" >Modificar</button>
    
        
        
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js" integrity="sha512-Eezs+g9Lq4TCCq0wae01s9PuNWzHYoCMkE97e2qdkYthpI0pzC3UGB03lgEHn2XM85hDOUF6qgqqszs+iXU4UA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="modificarPrioridadCategorias.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>

    
</body>
</html>