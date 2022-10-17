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
    <link rel="stylesheet" href="gestionProductos.css">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <? include('../../../Recursos/includeHead.php') ?>
    <title>Lista de servicios</title>
</head>
<body>
    <section id="header-menu" class="header-menu">

    </section>

    <section id ="contenedorSelects" class="contenedor">
        <br><br><br>
        <select name="SelectCategoria" id="SelectCategoria">
            <option selected="true" disabled="disabled">Categoría</option>
        </select>
        <br><br><br>
        <select name="SelectProducto" id="SelectProducto">
            <option selected="true" disabled="disabled">Producto</option>
        </select>
        <br><br>
        <label class="switch">
            <input type="checkbox" id="cbox">
            <span class="slider"></span>
        </label>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="gestionProductos.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    <? include('../../../Recursos/notificaciones.js') ?>
</body>
</html>