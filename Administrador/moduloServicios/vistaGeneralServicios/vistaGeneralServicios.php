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
    <link rel="stylesheet" href="vistaGeneralServicios.css">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <? include('../../../Recursos/includeHead.php') ?>
    <title>Lista de servicios</title>
</head>
<body>
    <section id="header-menu" class="header-menu">

    </section>

    <section class="search">
        <form action="GET">
            <input type="text" class="searchElement" placeholder="busca Servicios, categorias..." id="">
            <button type="submit" class="searchButton">Buscar</button>
        </form>

    </section>

    
    <section class="contenedorTablaServicios">
        <table class="tablaServicios">

        </table>

        <button class="btnAdd"> Añadir </button>

    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="vistaGeneralServicios.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
</body>
</html>