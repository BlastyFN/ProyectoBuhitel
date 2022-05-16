<?php 
session_start();
if ($_SESSION['sesionPersonal']['Tipo']!='Administrador') {
            header("Location: /Buhitel", TRUE, 301);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="verPersonalEspecifico.css">
    <link rel="stylesheet" href="../../../recursos/estilos-menu.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viendo información del personal seleccionado</title>
</head>
<body>
    
    <section id="header-menu" class="header-menu">

    </section>

    <div class="main">
        <h1 class="titulo" id='<?php echo $simple; ?>' ></h1>
        <section class="infoPersonal">

            <p class="nombre"></p>
            <p class="tipoPersonal"></p>
            <p class="correo"></p>
            <p class="password"></p>
            <p class="seguroSocial"></p>
        </section>
        <section class="botones">
            <button class="boton volver">Volver</button>
            <button class="boton modificar">Modificar</button>
            <button class="boton eliminar">Eliminar</button>
        </section>
    </div>


    <script src="verPersonalEspecifico.js"></script>
    <script src="../../../recursos/clase-menu.js"></script>
    <script src="../../../recursos/menuTransition.js"></script>

</body>
</html>