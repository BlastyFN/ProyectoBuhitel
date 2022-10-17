<?php 
session_start();
if ($_SESSION['sesionPersonal']['Tipo']!='Servicio') {
            header("Location: /index.php", TRUE, 301);
}
else {
    # code...
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <? include('../../../Recursos/includeHead.php') ?>
    <title>Servicio</title>
    <link rel="stylesheet" href="styleVisualizar.css">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>

<body>
<section id="header-menu" class="header-menu" >

</section>
    <div id="Encabezado">
        <h2 class="CentrarTexto TituloPrincipal">Servicio a la habitacion</h1>
    </div>
    <br><br>
    <section class="Contenedor">
        
        <section class="Formulario">
            <h3 class="CentrarTexto">Información</h3>
            
                <!-- <input type="text" name="Habitacion"  placeholder="Habitacion" class="CampoCompleto" id ="cmpHabitacion">
                <br><br>
                <input type="text" name="Modelo"  placeholder="Modelo" class="CampoMitad" id ="cmpModelo">
                <input type="text" name="Color"  placeholder="Color" class="CampoMitad" id ="cmpColor">
                <br><br>
                <input type="text" name="Placas"  placeholder="Placas" class="CampoMitad" id ="cmpPlacas">
                <input type="text" name="Lugar"  placeholder="Lugar" class="CampoMitad" id ="cmpLugar">
                <br><br>
                <textarea placeholder="Notas" name="Notas" cols="40" rows="7" class="CampoCompleto" id ="cmpNotas"></textarea> -->
                <h1 class="TextoCompleto TextoAlineado Azul RedTop RedMid" id="txtHab">Habitación</h1>
                <h1 class="TextoCompleto Verde RedMid" id="txtServ">Pedido: #</h1>
                <h1 class="TextoCompleto Verde RedMid" id="txtHora">Hora: </h1>
                <h1 class="TextoCompleto Verde RedMid" id="txtEstatus">Estatus: </h1>
                <section id="SeccionCarritos">

                </section>
                <button class="Verde RedMid TextoCompleto" id="btnConfirmar" >Comenzar</button>
                
                <button class="Rojo RedMid RedBot TextoCompleto" id="btnCancelar" >Cancelar</button>

            
            
        </section>

        <section class="Tabla ">
            <h3 class="CentrarTexto">Pedidos</h3>
            <table>
                <thead class="Morado">
                    <tr class="">
                        <th>Servicio</th>
                        <th>Hora</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody id="CuerpoTabla">
                    
                </tbody>

              
            </table>
        </section>
    </section>
    <script src= "JSGestionarPedidos.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    <? include('../../../Recursos/notificaciones.js') ?>
</body>
</html>