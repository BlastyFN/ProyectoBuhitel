<?php 
    session_start();
    include "bdReservacion.php";
    if (isset($_POST['Habitacion']) && isset($_POST['Reservacion'])) {
        $Habitacion = $_POST['Habitacion'];
        $Reservacion = $_POST['Reservacion'];
        $bd = new database();
        $regH = $bd->reservarHab($Reservacion, $Habitacion);
        echo $regH;
    }

?>