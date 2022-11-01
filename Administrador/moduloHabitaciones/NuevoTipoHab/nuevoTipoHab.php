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
    <link rel="stylesheet" href="nuevoTipoHab.css">
    <? include('../../../Recursos/includeHead.php') ?>
    <title>Nuevo tipo de habitacion</title>
    <style>
        .without_ampm::-webkit-datetime-edit-ampm-field {
        display: none;
        }
        input[type=time]::-webkit-clear-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        -o-appearance: none;
        -ms-appearance:none;
        appearance: none;
        margin: -10px; 
        }
    </style>
</head>
<body>
    
    <section id="header-menu" class="header-menu">

    </section>

    <h1>
        Ingrese la información de la nueva habitación
    </h1>
    <section class="contFormulario">
        <form class="ingresarTipoForm" action="" method="post">
            <input type="text" class="formText" id="nombreTipo" placeholder="Nombre del nuevo tipo de habitación" maxlength="30" required>
            <br>
            <input type="number" class="formText" id="precioTipo" placeholder="Precio por noche" min="1" required>
            <br>
            <input type="number" class="formText" id="numCamas" placeholder="Número de camas" min="1" max="7" required>
            <br>
            <input type="time" class="formText without_ampm" id="tiempoLimpNormal" placeholder="Tiempo estimado de limpieza normal" min="00:01" required>
            <br>    
            <input type="time" class="formText without_ampm" id="tiempoLimpProf" placeholder="Tiempo estimado de limpieza profunda" min="00:01" required>
            <br>
    
            <button type="submit" class="enviarInfo">Aceptar</button>
        </form>
        
    </section>
    


    <script src="../../../Recursos/clase-menu.js"></script>
    
    <script src="../../../Recursos/menuTransition.js"></script>
    <script src="registrarTipoHab.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <? include('../../../Recursos/includeScripts.php') ?>

</body>
</html>