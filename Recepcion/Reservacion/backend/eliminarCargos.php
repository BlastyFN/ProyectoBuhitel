<?php 
    session_start();
    include "bdReservacion.php";
    if (isset($_POST['Reservacion'])) {
        $Reservacion = $_POST['Reservacion'];
        $bd = new database();
        $regH = $bd->eliminarCargos($Reservacion);
        echo 1;
    }

?>