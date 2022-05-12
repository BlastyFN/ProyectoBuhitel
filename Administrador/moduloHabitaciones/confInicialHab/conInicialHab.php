<?php 
session_start();
if ($_SESSION['sesionPersonal']['Tipo']!='Administrador') {
            header("Location: /Buhitel", TRUE, 301);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../recursos/estilos-menu.css">
    <link rel="stylesheet" href="confInicialHab.css">
    <title>Configuración inicial de hab</title>
</head>
<body>
    
    <section id="header-menu" class="header-menu">
        
    </section>

    <h1 >
        ¡Configura tu hotel!
    </h1>
    <section class="contFormulario">
        <form class="confInicial" action="" method="post" id="formConfInicial">
            <p>
            <input type="number" class="formText" placeholder="Número de pisos del hotel" id="input_NumPisos" min="0" max = "5">
            </p>
            <p>
            <div class="contInputPisos">

            </div>
            
            <button type="submit" id="btnEnviar" class="enviarInfo">Aceptar</button>
        </form>
        
    </section>
    
    <script src="../../recursos/clase-menu.js"></script>
    <script src="../../recursos/menuTransition.js"></script>
    <script src="EnviarInfo.js"></script>

</body>
</html>