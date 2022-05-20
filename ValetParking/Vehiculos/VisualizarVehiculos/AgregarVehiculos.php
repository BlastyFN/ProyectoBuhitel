<?php 
session_start();
if ($_SESSION['sesionPersonal']['Tipo']!='Valet') {
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
    <title>Vehículos</title>
    <link rel="stylesheet" href="styleVisualizar.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../Recursos/estilos-menu.css">
</head>
<body>
    <div id="Encabezado">
        <h2 class="CentrarTexto TituloPrincipal">Valet Parking</h1>
    </div>
    <br><br>
    <section class="Contenedor">
        
        <section class="Formulario">
            <h3 class="CentrarTexto">Añadir</h3>
            <form id="InfoVehiculo">
                <input type="text" name="Habitacion"  placeholder="Habitacion" class="CampoCompleto" id ="cmpHabitacion">
                <br><br>
                <input type="text" name="Modelo"  placeholder="Modelo" class="CampoMitad" id ="cmpModelo">
                <input type="text" name="Color"  placeholder="Color" class="CampoMitad" id ="cmpColor">
                <br><br>
                <input type="text" name="Placas"  placeholder="Placas" class="CampoMitad" id ="cmpPlacas">
                <input type="text" name="Lugar"  placeholder="Lugar" class="CampoMitad" id ="cmpLugar">
                <br><br>
                <textarea placeholder="Notas" name="Notas" cols="40" rows="7" class="CampoCompleto" id ="cmpNotas"></textarea>
                <button class="Naranja BtonModel CampoCompleto" id="btnConfirmar" disabled>Confirmar</button>
            </form>
            
        </section>

        <section class="Tabla ">
            <h3 class="CentrarTexto">Vehículos</h3>
            <table>
                <thead class="Morado">
                    <tr class="">
                        <th>Habitacion</th>
                        <th>Modelo</th>
                        <th>Placas</th>
                    </tr>
                </thead>
                <tbody id="CuerpoTabla">
                    
                </tbody>

              
            </table>
        </section>
    </section>
    <script src= "JSAgregarVehiculos.js"></script>
    <script src="../../../Recursos/clase-menu.js"></script>
    <script src="../../../Recursos/menuTransition.js"></script>
</body>
</html>