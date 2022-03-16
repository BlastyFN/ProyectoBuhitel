<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservacion</title>
    <link rel="stylesheet" href="../styleR.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Titulo principal-->
    <h2 class="TituloPrincipal CentrarTexto">Reservación</h2>
    <br>
    <br>
    <!-- Contenedor Datos Huesped-->
    <form action="Reservacion.php" >
    <section class="ContenedorFormulario Contenedor">
        <div class="AsideIzq"></div>
        <div class="CamposFijos">
            <h1 class="CentrarTexto">Titular</h1>
            <br>
            <input type="text" placeholder="Nombre" class="EntradaTexto CampoCentrado" name="Nombre">
            <br>
            <input type="text" placeholder="Apellidos" class="EntradaTexto CampoCentrado" name="Apellidos">
            <br>
            <input type="text" placeholder="Contacto" class="EntradaTexto CampoCentrado" name="Contacto">
        </div>
        <!-- Contenedor Datos Fechas Checks-->
        <div class="CamposFijos">
            <h1 class="CentrarTexto">Fecha</h1>
            <br>
            <input type="datetime-local" placeholder="Check-In" class="EntradaTexto CampoCentrado TextMen" name="CheckIn">
            <br>
            <input type="datetime-local" placeholder="Check-Out" class="EntradaTexto CampoCentrado TextMen" name="CheckOut">
        </div>
        <!-- Contenedor Datos Habitaciones-->
        <div class="CamposExtensibles">
            <h1 class="CentrarTexto">Habitaciones</h1>
            <br>
            <!-- Campos de tipos-->
            <div id="Entradas">
            </div>
            <button class="Naranja Completo" id="addImput">AÑADIR</button>
            <h1 class="CentrarTexto">$0</h2>
        </div>
        
    </section>
    <br>
    <br>
    
    <input type="submit" value ="Reservar" class="Verde BotonSMT" id="Reservar"> 
    </form>
</body>
<script src= "JSReservacion.js"></script>
</html>