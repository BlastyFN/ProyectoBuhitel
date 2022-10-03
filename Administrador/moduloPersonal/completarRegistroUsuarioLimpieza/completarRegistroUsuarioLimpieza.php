<?php 
session_start();
//if ($_SESSION['sesionPersonal']['Tipo']!='Administrador') {
//            header("Location: /index.php", TRUE, 301);
//}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <link rel="stylesheet" href="completarRegistroUsuarioLimpieza.css">
    <? include('../../../Recursos/includeHead.php') ?>
    <title>Complete la información del usuario de limpieza </title>
</head>
<body>
    <section id="header-menu" class="header-menu">

    </section>

    <h1 style="text-align: center;">
        Ingrese la información del nuevo usuario
    </h1>
    <section class="contFormulario">
        <form class="formNuevoUsuario" action="" method="post">
            <div class="campo">
                <span>Hora de inicio de jornada</span><input type="time" class="formText" id="inicioJornada">
            </div>

             <div class="campo">
                <span>Hora de fin de jornada </span><input type="time" class="formText" id="finJornada" >
            </div>        
            
            <div class="campo">
                <span>Hora de inicio de descanso </span><input type="time" class="formText" id="inicioDescanso">
            </div>

            <div class="campo">
                <span>Hora de fin de descanso </span><input type="time" class="formText" id="finDescanso" >
            </div>


            <br>
            
    
            <button type="submit" class="enviarInfo">Aceptar</button>
  
        </form>
        
    </section>
    <script src="completarRegistroUsuarioLimpieza.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>