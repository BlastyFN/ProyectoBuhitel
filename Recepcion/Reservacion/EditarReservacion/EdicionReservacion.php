<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link rel="stylesheet" href="styleER.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Titulo principal-->
    <h2 class="TituloPrincipal CentrarTexto">Editar Reservación</h2>
    <br>
    <br>
    <!-- Contenedor Datos Huesped-->
    <form>
    <section class="ContenedorFormulario Contenedor">
        <div class="AsideIzq"></div>
        <div class="CamposHuesped">
            <h1 class="CentrarTexto">Titular</h1>
            <br>
            <input type="text" placeholder="Nombre" class="EntradaTexto CampoCentrado" name="Nombre" id="CampoNombre">
            <br>
            <input type="text" placeholder="Apellidos" class="EntradaTexto CampoCentrado" name="Apellidos" id = "CampoApellidos">
            <br>
            <input type="text" placeholder="Contacto" class="EntradaTexto CampoCentrado" name="Contacto" id = "CampoContacto">
            <button class="Verde BotonSMT Completo" id="EditarHues" disabled>EDITAR</button>
        </div>
        <div class="CamposHabitaciones">
            <div class="Contenedor" id="Subcontenedor">
                <!-- Contenedor Datos Fechas Checks-->
                <div class="CamposFechas">
                    <h1 class="CentrarTexto">Fecha</h1>
                    <br>
                    <input type="datetime-local" placeholder="Check-In" class="EntradaTexto CampoCentrado TextMen" id="Campo_CHECKIN" name="CheckIn">
                    <br>
                    <input type="datetime-local" placeholder="Check-Out" class="EntradaTexto CampoCentrado TextMen" id="Campo_CHECKOUT" name="CheckOut">
                    <br>
                            
                </div>
                <!-- Contenedor Datos Habitaciones-->
                <div class="CamposExtensibles CamposFechas">
                    <h1 class="CentrarTexto">Habitaciones</h1>
                    <br>
                            <!-- Campos de tipos-->
                    <div id="Entradas">
                    </div>
                    <button class="Naranja Completo" id="addInput">AÑADIR</button>
                    <h1 class="CentrarTexto" id="PrecioTotal">$0</h2>
                </div>
            </div>
            <button class="Verde BotonSMT Completo" id="EditarHab">EDITAR</button>
        </div>
    </section>
    <br>
    <br>
    
    
    </form>
</body>
<script src= "JEdicionReservacion.js"></script>
</html>