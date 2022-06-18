<?php 
    session_start();
    include "bdservicios.php";
    if (isset($_SESSION['sesionPersonal']['Hotel'])) {
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $bd = new database();
        $res = $bd->consultarCategorias($Hotel);
        if (isset($res[0])) {
            $info = json_encode($res);
            echo $info;        
        }
        else{
            echo 0;
        }
        
    }
    else {
        echo "x";
    }
    
?>