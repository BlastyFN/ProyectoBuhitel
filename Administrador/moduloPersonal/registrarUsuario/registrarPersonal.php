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
    <link rel="stylesheet" href="registrarPersonal.css">
    <? include('../../../Recursos/includeHead.php') ?>
    <title>Registro de nuevo usuario</title>

</head>
<body>
    <section id="header-menu" class="header-menu">

    </section>

    <h1>
        Ingrese la información del nuevo usuario
    </h1>
    <section class="contFormulario">
        <form class="formNuevoUsuario" action="" method="post">
            <input type="text" class="formText" id="nombreUsr" placeholder="Nombres">
            <div class="apellidos">
                <input type="text" class="formText" id="apellidoP" placeholder="Apellido paterno">
                <input type="text" class="formText" id="apellidoM" placeholder="Apellido materno">
            </div>
            
            <select name="tipoPersonal" id="tipoPersonal" class="formText">
                <option selected="true" disabled>Tipo de personal</option>
                <option value="Recepcion">Recepcionista</option>
                <option value="Limpieza">Personal de limpieza</option>
                <option value="Valet">Valet parking</option>
                <option value="Servicio">Personal de servicio</option>
                
            </select>

            <input type="text" class="formText" id="correoUsr" placeholder="Correo">
            <input type="text" class="formText" id="password" placeholder="Contraseña">
            <input type="text" class="formText" id="seguroSocial" placeholder="Número de seguridad social">
            <br>
            
    
            <button type="submit" class="enviarInfo">Aceptar</button>
  
        </form>
        
    </section>
    <script src="registrarPersonal.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <? include('../../../Recursos/notificaciones.js') ?>
</body>
</html>