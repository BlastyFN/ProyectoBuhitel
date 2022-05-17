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
    <link rel="stylesheet" href="../../recursos/estilos-menu.css">
    <link rel="stylesheet" href="modificarPisosYHabs.css">
    <title>Document</title>
</head>
    <section class="header-menu" id="header-menu">

    </section>
    <section class="contenedorPisos">

    </section>

<body>
    
    <script src="../../recursos/clase-menu.js"></script>
    <script src="../../recursos/menuTransition.js"></script>
    <script src="modificarPisosYHabs.js"></script>
</body>
</html>