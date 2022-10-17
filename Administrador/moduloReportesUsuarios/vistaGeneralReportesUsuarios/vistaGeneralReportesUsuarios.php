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
    <link rel="stylesheet" href="vistaGeneralReportesUsuarios.css">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <title>Lista de usuarios</title>
    <? include('../../../Recursos/includeHead.php') ?>
</head>
<body>
    <section id="header-menu" class="header-menu">

    </section>

    <section class="search">
        <form action="GET">
            <input type="text" class="searchElement" placeholder="busca reportes, tipos de reportes..." id="">
            <button type="submit" class="searchButton">Buscar</button>
        </form>

    </section>

    <section class="contenedorTablaReportes">
        <table class="tablaReportes">

        </table>

    

    </section>
    
    <script src="vistaGeneralReportesUsuarios.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    <? include('../../../Recursos/notificaciones.js') ?>
</body>
</html>