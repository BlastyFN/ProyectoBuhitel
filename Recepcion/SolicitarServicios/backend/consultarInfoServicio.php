<?php 
    session_start();
    include "bdservicios.php";
    if (isset($_POST['Servicio'])) {
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $Servicio = $_POST['Servicio'];
        $bd = new database();
        $res = $bd->consultarInfoServicio($Hotel, $Servicio);
        if (isset($res[0])) {
            $info = json_encode($res[0]);
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