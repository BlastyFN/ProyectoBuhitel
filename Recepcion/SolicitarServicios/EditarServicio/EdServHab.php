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
    <link rel="stylesheet" href="../styleServicios.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <? include('../../../Recursos/includeHead.php') ?>
    <title>Solicitar Servicio a la Habitación</title>
</head>
<body>
    <h2 class="alinearTexto">Editar Servicio a la Habitación</h2>
     <!-- Contenedor global -->
    <section class="contenedor">
        <!-- Mitad Izquierda -->
        <section class="Mitad">
            <br><br><br>        
            <input type="text" name="" id="cmpHabCamb" placeholder="Habitación" class="CamposCentrados">
            <br><br>
            <button type="submit" class="Naranja CamposCentrados ModelBtn" id="btnCambiar" disabled>Cambiar</button>
            <br><br>
            <!-- Contenedor Datos Extensbles-->
        <div class="CamposExtensibles" id="SeccionTotal">
            <div class="Disposicion">
            <h1 class="">Categoría</h1>
            <h1>Elemento</h1>
            <h1>Cant</h1>
            
            </div>
            
            <br>
            <!-- Campos de tipos-->
            <section id="ContenedorEntradas" >
                
            </section>
            <button class="Naranja Completo ModelBtn" id="addImput" >AÑADIR</button>
            <br><br>
            <button class="Rojo Completo ModelBtn" id="popImput" >ELIMINAR</button>

            
        </div>
            <br><br>
        
        </section>
        <!-- Mitad Izquierda -->
        <!-- Mitad Derecha -->
        <section class="Mitad">
        <br><br><br>
        <div class="Tarjeta Azul" id="TarServ">
            <h1 class="Info" id="textoHabitacion">Habitacion</h1>
            <div class="Info">
                
                <p id="TextoNombre">  Nombre </p>
                <p id="TextoApellidos"> Apellidos </p>
                <p id="TextoFecha"> Fecha </p>
                <p id="TextoPrecio"> Precio Total = $0</p>
                
                
            </div>
                <button class="Naranja ModelBtn Ult" id="btnCompletar"> Verificar</button>
        </section>
        <!-- Mitad Derecha -->
    </section>
    <!-- Contenedor global -->
    
</body>
<script src= "JSEdServHab.js"></script>
<script src="../../../Recursos/clase-menu.js"></script>
<script src="../../../Recursos/menuTransition.js"></script>
</html>