<?php 
session_start();
//if ($_SESSION['sesionPersonal']['Tipo']!='Administrador') {
//            header("Location: /index.php", TRUE, 301);
//}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pagPrincipalAdmin.css">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <? include('../../../Recursos/includeHead.php') ?>
    <title>Buhitel: Administrador</title>
</head>
<body>

    <section id="header-menu" class="header-menu" >

    </section>

    <section class="main">
        <section class="containCards">
            <div class="contIndividual" >
                    <div class="cardBoard ">Información de habitaciones</div>
                    <div class="card infoHabs"></div>

            </div>

            <div class="contIndividual" >
                    <div class="cardBoard">Información de reportes</div>
                    <div class="card infoReportes"></div>
            </div>

            <div class="contIndividual" >
                    <div class="cardBoard">Información de limpieza</div>
                    <div class="card infoPersonal"></div>
            </div>

            <div class="contIndividual" >
                    <div class="cardBoard">Información estadística</div>
                    <div class="card infoEstadistica"></div>
            </div>
            
        </section>
     </section>

    
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    <script src="pagPrincipalAdmin.js"></script>

    
</body>
</html>