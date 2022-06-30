<?php 
    session_start();
    include "bd.php";
    if (isset($_SESSION['sesionPersonal']['Hotel'])) {
        date_default_timezone_set('America/Mexico_City');
        $zonahoraria = date_default_timezone_get();
        $Hoy = date('Y-m-d');
        $MañanaNum = strtotime($Hoy)+86400;
        $Mañana = date('Y-m-d', $MañanaNum);
        $Usuario = $_SESSION['sesionPersonal']['ID'];
        $bd = new database();
        $res = $bd->consultarLimpiezas($Usuario, $Hoy, $Mañana);
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