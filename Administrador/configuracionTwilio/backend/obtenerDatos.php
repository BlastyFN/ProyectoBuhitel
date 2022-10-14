<?php 
    session_start();
    include "bdTwilio.php";
    if (isset($_SESSION['sesionPersonal'])) {
        $bd = new database();
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $res = $bd->consultarEstados($Hotel);
        if (isset($res[0])) {
            $datos = json_encode($res[0]);
            echo $datos;
        }
        
    }
    else{
        echo "0";
    }
    
?>