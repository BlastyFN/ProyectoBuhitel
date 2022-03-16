<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edición Reservacion</title>
    <link rel="stylesheet" href="../../design/styleR.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Titulo principal-->
    <h2 class="TituloPrincipal CentrarTexto">Edición Reservación</h2>
    <br>
    <br>
    <!-- Contenedor Datos Huesped-->
    <form action="EdicionReservacion.php" >
    <section class="ContenedorFormulario Contenedor">
        <div class="AsideIzq"></div>
        <div class="CamposCuartos">
            <h1 class="CentrarTexto">Titular</h1>
            <br>
            <input type="text" placeholder="Nombre" class="EntradaTexto CampoCentrado" name="Nombre">
            <br>
            <input type="text" placeholder="Apellidos" class="EntradaTexto CampoCentrado" name="Apellidos">
            <br>
            <input type="text" placeholder="Contacto" class="EntradaTexto CampoCentrado" name="Contacto">
        </div>
        <!-- Contenedor Datos Fechas Checks-->
        <div class="CamposCuartos">
            <h1 class="CentrarTexto">Fecha</h1>
            <br>
            <input type="datetime-local" placeholder="Check-In" class="EntradaTexto CampoCentrado TextMen" name="CheckIn">
            <br>
            <input type="datetime-local" placeholder="Check-Out" class="EntradaTexto CampoCentrado TextMen" name="CheckOut">
        </div>
        <!-- Contenedor Datos Habitaciones-->
        <div class="CamposCuartos">
            <h1 class="CentrarTexto">Habitaciones</h1>
            <br>
            <!-- Campo de habitacion-->
            <div id="EntradasHab">
                <input type="text" placeholder="Habitación" class="EntradaTexto CampoCentrado" name="Habitacion1">
            </div>
            <button class="Naranja Completo" id="addHab">AÑADIR</button>
            
        </div>
        <!-- Contenedor Datos Cargos-->
        <div class="CamposCuartos">
            <h1 class="CentrarTexto">Cargos</h1>
            <br>
            <div id="EntradasCargo">
            <input type="text" placeholder="Concepto" class="EntradaTexto TresCuartos" name="Concepto1">
                <input type="number" placeholder="$0" class="EntradaTexto UnCuarto" name="Monto1">
            </div>
            <button class="Naranja Completo" id="addCargo">AÑADIR</button>
            
        </div>
        
    </section>
    <br>
    <br>
    
    <input type="submit" value ="Editar" class="Verde BotonSMT" id="Reservar"> 
    </form>
</body>
<script src= "JEdicionReservacion.js"></script>
</html>