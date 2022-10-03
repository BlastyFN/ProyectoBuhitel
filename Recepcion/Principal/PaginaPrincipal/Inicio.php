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
    <link rel="stylesheet" href="InicioR.css">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <? include('../../../Recursos/includeHead.php') ?>

    <title>Buhitel: Recepción</title>
</head>
<body>

    <section id="header-menu" class="header-menu" >

    </section>

    <section class="main">
        <section class="containCards">
            <div class="contIndividual" >
                <div class="cardBoard ">Pendientes</div>
                <div class="card infoHabs" id="ContChecks">
                    <ol>
                        <li id="CINText">3 Check-Ins Pendientes</li>
                        <li id="COTText">2 Check-Outs Pendientes</li>
                    </ol>
                </div>

            </div>

            <div class="contIndividual" id="ContDisponibilidad">
                <div class="cardBoard">Disponibilidad</div>
                <div class="card">
                    <br><br>
                    <h1 id= "PorDisponibilidad">70%</h1>
                    <p class="TCentral">Disponible</p>
                </div>
            </div>

            <div class="contIndividual" id="ContTipos">
                <div class="cardBoard">Tipos</div>
                <div class="card">
                    <ol id="ListaDisponibles">

                    </ol>
                </div>
            </div>

 
            
        </section>
     </section>

    
    <script src="../../../../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    <script src="InicioR.js"></script>

    
</body>
</html>