<?php 
    session_start();
    include "bdReservacion.php";
    if (isset($_POST['Reservacion']) && isset($_POST['CIN']) && isset($_POST['COUT'])) {
        $Reservacion = $_POST['Reservacion'];
        $CheckIn = $_POST['CIN'];
        $CheckOut = $_POST['COUT'];
        $bd = new database();
        $regF = $bd->actualizarFechas($Reservacion, $CheckIn, $CheckOut);
        echo $regF;
        $regH = $bd->borrarHabitaciones($Reservacion);
    }

?>