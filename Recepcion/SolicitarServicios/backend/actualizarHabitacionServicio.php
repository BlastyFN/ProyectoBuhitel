<?php 
    session_start();
    include "bdservicios.php";
    if (isset($_POST['Servicio']) && isset($_POST['Habitacion'])) {
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $Servicio = $_POST['Servicio'];
        $Habitacion = $_POST['Habitacion'];
        $bd = new database();
        $res = $bd->actualizarHabitacion($Hotel, $Habitacion, $Servicio);
        $info = json_encode($res[0]);
        echo $info;
        
    }
    else {
        echo "x";
    }
    
?>