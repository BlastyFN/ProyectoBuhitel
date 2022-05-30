<?php 
session_start();
//if ($_SESSION['sesionPersonal']['Tipo']!='Administrador') {
 //           header("Location: /index.php", TRUE, 301);
//}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <link rel="stylesheet" href="vistaReporteUsuario.css">

    <title>Nuevo tipo de habitacion</title>
</head>
<body>
    
    <section id="header-menu" class="header-menu">

    </section>

    <h1>
        Vista específica de reporte
    </h1>
    <section class="chat">

        <p class="destinatario">Personal asignado: </p>
        <div class="cuerpoChat">
            <div class="contenedorMensajes">

            </div>
            <div class="envioMensaje">
                <input type="text" class="nuevoMensaje">
                <button class="enviarMensaje">></button>

            </div>
        </div>
        
    </section>
    


    <script src="../../../Recursos/clase-menu.js"></script>
    
    <script src="../../../Recursos/menuTransition.js"></script>
    <!-- <script src="registrarTipoHab.js"></script> -->


</body>
</html>