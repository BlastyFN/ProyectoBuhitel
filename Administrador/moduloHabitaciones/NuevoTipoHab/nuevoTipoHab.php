<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../estilos-menu.css">
    <link rel="stylesheet" href="nuevoTipoHab.css">

    <title>Nuevo tipo de habitacion</title>
</head>
<body>
    
    <section id="header-menu" class="header-menu">

    </section>

    <h1>
        Ingrese la información de la nueva habitación
    </h1>
    <section class="contFormulario">
        <form class="ingresarTipoForm" action="" method="post">
            <input type="text" class="formText" id="nombreTipo" placeholder="Nombre del nuevo tipo de habitación">
            <br>
            <input type="number" class="formText" id="precioTipo" placeholder="Precio por noche">
            <br>
            <input type="number" class="formText" id="numCamas" placeholder="Número de camas">
            <br>
            <input type="time" class="formText" id="tiempoLimpNormal" placeholder="Tiempo estimado de limpieza normal">
            <br>    
            <input type="time" class="formText" id="tiempoLimpProf" placeholder="Tiempo estimado de limpieza profunda">
            <br>
    
            <button type="submit" class="enviarInfo">Aceptar</button>
        </form>
        
    </section>
    


    <script src="../../recursos/clase-menu.js"></script>
    
    <script src="../../recursos/menuTransition.js"></script>
    <script src="registrarTipoHab.js"></script>


</body>
</html>