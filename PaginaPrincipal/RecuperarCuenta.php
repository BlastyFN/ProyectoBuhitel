<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar</title>
    <link rel="shortcut icon" href="assets/LogoBT.png">
    <link rel="stylesheet" href="design/stylesP.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
<!-- NAVEGACION -->
    <nav class="EspecialNav">
        <div class="logo">
            <img class="img_logo" src="assets/LogoT.png" alt="Logo">
        </div>
        <ul class="links_nav"> 
            <li> <a href="../index.php">Inicio</a></li>
            <li> <a href="../index.php">Acerca De</a></li>
            <li> <a href="../index.php">Funcionalidades</a></li>
            <li> <a href="Registro.php">Registrar</a></li>
            <li> <a href="InicioSesion.php">Ingresar</a></li>
        </ul>
    </nav>
    <!-- /NAVEGACION -->
    <br><br>
    <!-- FOTO -->
    	<div class="Formulario contenedor ">
            
           
            <div  class="ImgFondo">
                <!-- <img src="assets/Fotos/Inicio_Registro.jpg" class="Fotografia" -->
                <form action="" class="FormularioInicio" method="" id="FormularioR">
                    <h1 class="TituloForm Morado">Recuperar Cuenta</h1>
                    <div class="EntradasIS">
                        
                        <input type="text" name="Correo" placeholder="Correo" class="EntradaF MargenesIn" id="CampoCorreoR">
                        <p class="MensajeError Oculto" id="MsjCorreoR">Este correo no está registrado</p>
                        
                        <br>
                        <input type="text" name="Clave" placeholder="Código" class="EntradaF MargenesIn Oculto" id="CampoClaveR">
                        <p class="MensajeError Oculto" id="MsjClave">Código no coincide</p>
                        <br>
                        <button type="submit" class="BtnSubmit BotonI" id="BotonCorreo" disabled> Validar </button>
                        <button type="submit" class="BtnSubmit BotonI Oculto" id="BotonClave" disabled> Verificar </button>
                    </div>
                    
                    

                </form>
            </div>
    			
    	</div>
    	
    <!-- /FOTO -->  
</body>
<script src= "backend/recuperar.js"></script>
</html>
