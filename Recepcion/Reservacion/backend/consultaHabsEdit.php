<?php 
    session_start();
    include "bdReservacion.php";
    if (isset($_SESSION['sesionPersonal']) && isset($_POST['Reservacion'])) {
        $bd = new database();
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $Reservacion = $_POST['Reservacion'];
        $res = $bd->consultarReservadas($Hotel, $Reservacion);
        if (isset($res[0])) {
            $datos = json_encode($res);
            echo $datos;
        }
        else {
            echo 0;
        }
    }
    
?>