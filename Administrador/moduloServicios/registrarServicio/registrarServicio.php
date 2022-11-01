<?php 
session_start();
if ($_SESSION['sesionPersonal']['Tipo']!='Administrador') {
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
    <link rel="stylesheet" href="registrarServicio.css">
    <? include('../../../Recursos/includeHead.php') ?>
    <title>Registro de nuevo servicio</title>
</head>
<body>
    <section id="header-menu" class="header-menu">

    </section>

    <h1>
        Ingrese la información del nuevo servicio
    </h1>
    <section class="contFormulario">
        <form class="formNuevoServicio" action="" method="post">
            <input type="text" class="formText" id="nombre" placeholder="Nombre del producto o servicio" maxlength="50" required>
            <div class="infoTipoPrecio">
                <input type="text" class="formText" id="tipo" placeholder="Tipo de producto" maxlength="50" required>
                <input type="number" class="formText" id="precio" placeholder="Precio unitario" min="1" required>
            </div>
            
    

            <textarea name="descripcion" class="formText" id="descripcion" rows= 10 placeholder="Descripción del producto" maxlength="80" required></textarea>
    
            <button type="submit" class="enviarInfo">Aceptar</button>
  
        </form>
        
    </section>
    <script src="registrarServicio.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <? include('../../../Recursos/includeScripts.php') ?>
</body>
</html>