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
    <link rel="stylesheet" href="modificarPisosYHabs.css">
    <? include('../../../Recursos/includeHead.php') ?>
    <title>Document</title>
</head>
    <section class="header-menu" id="header-menu">

    </section>
    <section class="contenedorPisos">

    </section>

<body>
    
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    <script src="modificarPisosYHabs.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <? include('../../../Recursos/includeScripts.php') ?>
</body>
</html>