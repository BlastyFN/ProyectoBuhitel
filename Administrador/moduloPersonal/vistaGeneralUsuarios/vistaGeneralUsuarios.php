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
    <link rel="stylesheet" href="vistaGeneralUsuarios.css">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <? include('../../../Recursos/includeHead.php') ?>
    <title>Lista de usuarios</title>
</head>
<body>
    <section id="header-menu" class="header-menu">

    </section>

    <section class="search">
    <br><br><br>

    </section>

    <section class="contenedorTablaPersonal">
        <table class="tablaPersonal">

        </table>

        <button class="añadir"> Añadir </button>

    </section>
    
    <script src="vistaGeneralUsuarios.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    <? include('../../../Recursos/includeScripts.php') ?>
</body>
</html>