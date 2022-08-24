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
    <link rel="stylesheet" href="modificarServicio.css">
    <title>modficación de personal</title>
</head>
<body>
    <section id="header-menu" class="header-menu">

    </section>

    <h1 class="titulo">
        Modificando el servicio
    </h1>
    <section class="contFormulario">
        <form class="formNuevoUsuario" action="" method="post">
            <input type="text" class="formText" id="nombre" placeholder="Nombre">
            <div class="infoPrecioCat">
                <input type="text" class="formText" id="categoria" placeholder="Categoría">
                <input type="number" class="formText" id="precio" placeholder="0">
            </div>
            
           

            <input type="text" class="formText" id="descripcion" placeholder="Descripción">

            <select name="existencia" id="existencia" class="formText">
                <option id="false" value="0">Agotado</option>
                <option id="true" value="1">En stock</option>

                
            </select>
            <br>
            
    
            <button type="submit" class="enviarInfo">Modificar</button>
  
        </form>
        
    </section>
    <script src="modificarPersonal.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    
</body>
</html>