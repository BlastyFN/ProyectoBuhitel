
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
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
            <li> <a href="Registro.php">Registrar</a></li>
            <li> <a href="">Ingresar</a></li>
        </ul>
    </nav>
    <!-- /NAVEGACION -->
    <br><br>
    <!-- FOTO -->
    	<div class="Formulario contenedor ">
            
           
            <div  class="ImgFondo">
                <!-- <img src="assets/Fotos/Inicio_Registro.jpg" class="Fotografia" -->
                <form action="" class="FormularioInicio" method="post" id="FormularioIS">
                    <h1 class="TituloForm Morado">Cambiar de contraseña</h1>
                    <div class="EntradasIS">
                        
                        <input type="password" name="NuevaClave" placeholder="Nueva Contraseña" class="EntradaF MargenesIn" id="CampoNuevaClave">
                        <p class="MensajeError Oculto" id="MsjClave1">La contraseña debe tener al menos una mayúscula, una minúscula y un número</p>
                        
                        <br>
                        <input type="password" name="ConfirmarClave" placeholder="Confirmar Contraseña" class="EntradaF MargenesIn" id="CampoConfirmarClave">
                        <p class="MensajeError Oculto" id="MsjClave2">Contraseñas no coincide</p>
                        <br>
                        <button type="submit" class="BtnSubmit BotonI" id="BotonCambiar" disabled> Cambiar </button>
                        <br>
                    </div>
                    
                    

                </form>
            </div>
    			
    	</div>
    	
    <!-- /FOTO -->  
</body>
<script src= "backend/cambio.js"></script>
</html>
