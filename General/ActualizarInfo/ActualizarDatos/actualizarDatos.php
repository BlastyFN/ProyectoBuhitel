<?php 
session_start();
if (isset($_SESSION['sesionPersonal'])) {
            
}
else{
    header("Location: /index.php", TRUE, 301);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <link rel="stylesheet" href="actualizarDatos.css">
    <title>modficación de personal</title>
</head>
<body>
    <section id="header-menu" class="header-menu">

    </section>

    <h1>
        Modificando tu información personal
    </h1>
    <section class="contFormulario">
        <form class="formNuevoUsuario" action="" method="post" id="NFormulario">
            <input type="text" class="formText" id="NNombre" placeholder="Nombres" name="Nombre">
            <div class="apellidos">
                <input type="text" class="formText" id="NApellidoP" placeholder="Apellido paterno" name="APaterno">
                <input type="text" class="formText" id="NApellidoM" placeholder="Apellido materno" name="AMaterno">
            </div>

            <input type="text" class="formText" id="NCorreo" placeholder="Correo" name ="Correo">
            <input type="text" class="formText" id="NTelefono" placeholder="Teléfono" name ="Telefono">
            <br>
            
    
            <button type="submit" class="enviarInfo" id="btnActualizar" disabled>Modificar</button>
  
        </form>
        <div class="formNuevoUsuario">
            <input type="password" placeholder="Contraseña" name="Clave" id="NClave1" class="formText">
            <input type="password" placeholder="Confirmar contraseña" name="Clave2" id="NClave2" class = "formText">
            <button type="submit" class="enviarInfo" id="btnClave" disabled>Confirmar</button>
          

        </div>
        <br><br>
    </section>
    <script src="JSactualizarDatos.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    
</body>
</html>