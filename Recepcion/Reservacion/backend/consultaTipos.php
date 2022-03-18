<?php 
    session_start();
    include "bdReservacion.php";
    if (isset($_SESSION['sesionPersonal'])) {
        $bd = new database();
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $res = $bd->consultaTipos($Hotel);
        if (isset($res[0])) {
            $datos = json_encode($res);
            echo $datos;
        }
        else {
            echo 0;
        }
    }
    
?>