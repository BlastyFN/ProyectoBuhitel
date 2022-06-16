<?php 
    session_start();
    include "bdReservacion.php";
    if (isset($_POST['Reservacion'])) {
        $Reservacion = $_POST['Reservacion'];
        $bd = new database();
        $cargos = $bd->consultarCargos($Reservacion);
        echo json_encode($cargos);
    }

?>