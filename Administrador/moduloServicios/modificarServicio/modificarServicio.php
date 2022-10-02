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
    <? include('../../../Recursos/includeHead.php') ?>
    <title>modficación de servicio</title>
</head>
<body>
    <section id="header-menu" class="header-menu">

    </section>

    <h1 class="titulo">
        Modificando el servicio
    </h1>
    <section class="contFormulario">
        <form class="formNuevoServicio" action="" method="post">
            <input type="text" class="formText" id="nombre" placeholder="Nombre">
            <div class="infoPrecioCat">
                <input type="text" class="formText" id="categoria" placeholder="Categoría">
                <select name="categoria" id="categoria" class="formText">
                    
                </select>
                <input type="number" class="formText" id="precio" placeholder="0">
            </div>
            
           

            <input type="text" class="formText" id="descripcion" placeholder="Descripción">

            <select name="existencia" id="existencia" class="formText">
                <option id="agotado" value="0">Agotado</option>
                <option id="stock" value="1">En stock</option>

                
            </select>
            <br>
            
    
            <button type="submit" class="enviarInfo">Modificar</button>
  
        </form>

        <div class="overlay">
        <div class="popup">
            <a href="#" id="cerrarPopup" class="cerrarPopup">
                x
            </a>
            <h4 class="nombreHab">Habitación 101</h4>
            Tipo de habitación <select name="tipoHabs" id="opcDesplegable" class="popupContent">

                
            </select>
            <h5 class="precioNoche popupContent">Precio por noche: $2</h5>
            <h5 class="numCamas popupContent">Número de camas: 1</h5>
            <h5 class="limpiezaNormal popupContent ">Tiempo de limpieza normal: 2 horas</h5>
            <h5 class="limpiezaProfunda popupContent ">Tiempo de limpieza profunda: 2 horas</h5> 
            <button class="desactivar">Desactivar</button>
            <button class="guardar">Guardar</button>
        </div>
    </div>
        
    </section>
    <script src="modificarPersonal.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    
</body>
</html>