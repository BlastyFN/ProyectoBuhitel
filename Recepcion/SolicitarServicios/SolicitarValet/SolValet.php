<?php 
session_start();
if ($_SESSION['sesionPersonal']['Tipo']!='Recepcion') {
            header("Location: /Buhitel", TRUE, 301);
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
    <link rel="stylesheet" href="../styleServicios.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <title>Solicitar Valet</title>
</head>
<body>
    <h2 class="alinearTexto">Valet Parking</h2>
     <!-- Contenedor global -->
    <section class="contenedor">
        <!-- Mitad Izquierda -->
        <section class="Mitad">
            <br><br><br>
            
            <form action="" method="post">
                <input type="text" name="" id="Habitacion" placeholder="Habitación" class="CamposCentrados">
                <br><br>
                <button type="submit" class="Naranja CamposCentrados ModelBtn" id="BtnVerificar">Verificar</button>
            </form>
        </section>
        <!-- Mitad Izquierda -->
        <!-- Mitad Derecha -->
        <section class="Mitad" id="ContenedorInfo">
            <br><br><br>
            <!-- TARJETA -->
            <div class="Tarjeta Azul" id="TarVehiculo">
                <h1 class="Info">Habitación</h1>
                <div class="Info">
                    
                    <p> Nombre</p>
                    <p> Apellidos</p>
                    <p> Contacto</p>
                    <p> Modelo</p>
                    <p> Placas</p>
                    
                </div>
                <button class="Verde ModelBtn Ult"> Pedir</button>
            </div>
        </section>
        <!-- Mitad Derecha -->
    </section>
    <!-- Contenedor global -->
    
</body>
<script src= "JSSolValet.js"></script>
</html>