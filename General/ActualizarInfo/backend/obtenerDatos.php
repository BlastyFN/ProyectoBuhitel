<?php 
    session_start();
    include "bdGeneral.php";
    if (isset($_SESSION['sesionPersonal'])) {
        $bd = new database();
        $Usuario = $_SESSION['sesionPersonal']['ID'];
        $res = $bd->consultaInfoPersonal($Usuario);
        if (isset($res[0])) {
            $datos = json_encode($res[0]);
            echo $datos;
        }
        
    }
    else{
        echo "0";
    }
    
?>