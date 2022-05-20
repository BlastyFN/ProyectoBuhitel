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
    <title>Reservacion</title>
    <link rel="stylesheet" href="styleR.css">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <section id="header-menu" class="header-menu" >

    </section>
    <!-- Titulo principal-->
    <h2 class="TituloPrincipal CentrarTexto">Reservación</h2>
    <br>
    <br>
    <!-- Contenedor Datos Huesped-->
    <form>
    <section class="ContenedorFormulario Contenedor">
        <div class="AsideIzq"></div>
        <div class="CamposFijos">
            <h1 class="CentrarTexto">Titular</h1>
            <br>
            <input type="text" placeholder="Nombre" class="EntradaTexto CampoCentrado" name="Nombre" id="CampoNombre">
            <br>
            <input type="text" placeholder="Apellidos" class="EntradaTexto CampoCentrado" name="Apellidos" id = "CampoApellidos">
            <br>
            <input type="text" placeholder="Contacto" class="EntradaTexto CampoCentrado" name="Contacto" id = "CampoContacto">
        </div>
        <!-- Contenedor Datos Fechas Checks-->
        <div class="CamposFijos">
            <h1 class="CentrarTexto">Fecha</h1>
            <br>
            <input type="datetime-local" placeholder="Check-In" class="EntradaTexto CampoCentrado TextMen" id="Campo_CHECKIN" name="CheckIn">
            <br>
            <input type="datetime-local" placeholder="Check-Out" class="EntradaTexto CampoCentrado TextMen" id="Campo_CHECKOUT" name="CheckOut">
        </div>
        <!-- Contenedor Datos Habitaciones-->
        <div class="CamposExtensibles">
            <h1 class="CentrarTexto">Habitaciones</h1>
            <br>
            <!-- Campos de tipos-->
            <div id="Entradas">
            </div>
            <button class="Naranja Completo" id="addImput" disabled>AÑADIR</button>
            <h1 class="CentrarTexto" id="PrecioTotal">$0</h2>
        </div>
        
    </section>
    <br>
    <br>
    
    <button class="Verde BotonSMT" id="Reservar" disabled>Reservar</button>
    </form>
</body>
<script src= "JSReservacion.js"></script>
<script src="../../../Recursos/clase-menu.js"></script>
<script src="../../../Recursos/menuTransition.js"></script>
</html>