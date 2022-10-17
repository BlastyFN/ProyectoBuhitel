<?php 
session_start();
if ($_SESSION['sesionPersonal']['Tipo']!='Limpieza') {
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
    <title>Limpiezas</title>
    <link rel="stylesheet" href="PaginaPrincipalLimpieza.css">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>

<body>
<section id="header-menu" class="header-menu" >

</section>
    <div id="Encabezado">
        <h2 class="CentrarTexto TituloPrincipal">Limpiezas</h1>
    </div>
    <br><br>
    <section class="Contenedor">
        
        <section class="Formulario">
            <h3 class="CentrarTexto">Próxima</h3>
            
            
                <h1 class="TextoCompleto TextoAlineado Azul RedTop RedMid" id="txtHab">Habitación</h1>
                <h1 class="TextoCompleto Verde RedMid" id="txtPiso">Piso: #</h1>
                <h1 class="TextoCompleto Verde RedMid" id="txtHora">Hora: </h1>
                <h1 class="TextoCompleto Verde RedMid" id="txtTipo">Tipo: </h1>
                <textarea name="txtNotas" placeholder="Notas:" class="Verde RedMid TextoCompleto tbox" id="txtNotas" cols="20" rows="5"></textarea>    
                <button class="Verde RedMid RedBot TextoCompleto" id="btnConfirmar" value="1">Comenzar</button>
                

            
            
        </section>

        <section class="Tabla ">
            <h3 class="CentrarTexto">Orden del día</h3>
            <table>
                <thead class="Morado">
                    <tr class="">
                        <th>Habitación</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody id="CuerpoTabla">
                    
                </tbody>

              
            </table>
        </section>
    </section>
    <script src= "PaginaPrincipalLimpieza.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
    <? include('../../../Recursos/includeScripts.php') ?>
</body>
</html>