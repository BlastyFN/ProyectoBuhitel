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
    <link rel="stylesheet" href="configurarServicios.css">
    <title>modficación de personal</title>
</head>
<body>
    <section id="header-menu" class="header-menu">

    </section>

    <h1>
        Configuración del chatbot
    </h1>
    <section class="contFormulario">
        <form class="formNuevoUsuario" action="" method="post" id="NFormulario">
            <h1>ChatBot Buhi</h1>
            <label class="switch">
                <input type="checkbox" id="cboxGeneral">
                <span class="slider"></span>
            </label>
            <button type="submit" class="enviarInfo" id="btnActualizar">Modificar</button>
        </form>

        
    </section>
    
  

    </section>
    <script src="JSconfigurarServicios.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    
</body>
</html>