<?php 
    session_start();
    include "bdGeneral.php";
    if (isset($_SESSION['sesionPersonal'])) {
        $bd = new database();
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $res = $bd->consultarPregunta($Hotel);
        if (isset($res[0])) {
            $datos = json_encode($res[0]);
            echo $datos;
        }
        
    }
    else{
        echo "0";
    }
    
?>