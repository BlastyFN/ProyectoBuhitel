<?php 
    session_start();
    include "bdReservacion.php";
    if (isset($_POST['Reservacion'])) {
        $bd = new database();
        $Reservacion = $_POST['Reservacion'];
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $res = $bd->consultarReservacion($Hotel, $Reservacion);
        if (isset($res[0])) {
            $datos = json_encode($res[0]);
            echo $datos;
        }
        else {
            echo 0;
            
        }
    }
    else {
        echo 1;
    }

?>