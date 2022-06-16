<?php 
session_start();
if ($_SESSION['sesionPersonal']['Tipo']!='Recepcion') {
            header("Location: /index.php", TRUE, 301);
}
else {
    # code...
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link rel="stylesheet" href="styleCon.css">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>

<section id="header-menu" class="header-menu" >

</section>

    <h2 class="alinearTexto">Gestión de Ocupaciones</h2>

</body>
<script src= "JSConsultarRes.js"></script>
<script src="../../../Recursos/clase-menu.js"></script>
<script src="../../../Recursos/menuTransition.js"></script>
</html>