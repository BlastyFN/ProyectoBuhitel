<?php 
    session_start();
    include "bdReservacion.php";
    if (isset($_POST['Reservacion']) && isset($_POST['Concepto']) && isset($_POST['Monto'])) {
        $Reservacion = $_POST['Reservacion'];
        $Concepto = $_POST['Concepto'];
        $Monto = $_POST['Monto'];
        $bd = new database();
        $regH = $bd->agregarCargo($Reservacion, $Concepto, $Monto);
        echo 2;
    }

?>