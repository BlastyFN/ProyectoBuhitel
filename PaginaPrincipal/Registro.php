<?php  
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
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
            <!-- Formulario de validación de correo -->

            
              <!-- /Formulario de validación de correo -->
            <div  class="ImgF">
                <section class="ContenedorCon" id="Confirmador">
                    <section id="SubContenedorCon" class="Morado Oculto">
                        <h2 class="Azul TituloForm">Introduce el código de seguridad enviado al correo</h2>
                        <h2 class="TituloForm" id="CorreoDesplegado">correoejemplo@gmail.com</h2>
                        <br>
                        <input type="text" name="Codigo" placeholder="______" class="EntradaC MargenesCon" id="CampCodigo">
                        <button type="submit" class="BtnCon Verde" id="BotonConfirmar" disabled> Confirmar </button>
                        <button type="submit" class="BtnCon Naranja" id="BotonCancelar" > Cancelar </button>
                    </section>
                </section>  
                <!-- <img src="assets/Fotos/Inicio_Registro.jpg" class="Fotografia" -->
                <form action="Registro.php" class="FormularioRegistro" method="" id="formularioReg">
                    <h1 class="TituloForm Morado">¡Registra tu hotel aquí!</h1>
                    <div class="contenedor">
                          <!-- Datos del administrador-->
                        <div class="Tercio">
                            <input type="text" name="Nombre" placeholder="Nombre" class="EntradaF MargenesReg" id="campo_Nombre">
                            <p class="MensajeError Oculto" id="Nombre" id="Nombre">El nombre no puede contener símbolos o números</p>
                            <input type="text" name="PApellido" placeholder="Primer Apellido" class="EntradaF MargenesReg " id="campo_PApellido">
                            <p class="MensajeError Oculto" id="PApellido">El apellido no puede contener símbolos o números</p>
                            <input type="text" name="SApellido" placeholder="Segundo Apellido" class="EntradaF MargenesReg " id="campo_SApellido">
                            <p class="MensajeError Oculto" id="SApellido">El apellido no puede contener símbolos o números</p>
                        </div>
                        <!-- Datos de contacto y hotel -->
                        <div class="Tercio">
                            <input type="text" name="Correo" placeholder="Correo electrónico" class="EntradaF MargenesReg " id="campo_Correo">
                            <p class="MensajeError Oculto" id="Correo">Esta no es una dirección de correo válida</p>
                            <input type="text" name="Telefono" placeholder="Teléfono" class="EntradaF MargenesReg " id="campo_Telefono">
                            <p class="MensajeError Oculto" id="Telefono">El teléfono debe tener 10 dígitos</p>
                            <input type="text" name="Hotel" placeholder="Hotel" class="EntradaF MargenesReg " id="campo_Hotel">
                            <p class="MensajeError Oculto" id="Hotel">El hotel no puede tener símbolos</p>
                            <button type="submit" class="BtnSubmit" id="BotonRegistrar" disabled> Registrar </button>
                        </div>
                        <!-- Confirmación de contraseña-->
                        <div class="Tercio">
                            <input type="password" name="Contrasena" placeholder="Contraseña" class="EntradaF MargenesReg " id="campo_Contrasena">
                            <p class="MensajeError Oculto" id="Contrasena">La contraseña no puede tener guiones y debe tener al menos una mayúscula, una minúscula y un número</p>
                            <input type="password" name="SegundaContrasena" placeholder="Confirmar Contraseña" class="EntradaF MargenesReg" id="campo_SegundaContrasena">
                            <p class="MensajeError Oculto" id="SegundaContrasena">Las contraseñas no coinciden</p>
                        </div>
                    </div>
                </form>
            </div>
    	</div>
    <!-- /FOTO -->
    <br><br><br>
    
</body>
<script src= "backend/validacion.js"></script>
</html>
