<?php 
    session_start();
    include "bdGeneral.php";
    if (isset($_SESSION['sesionPersonal'])) {
        date_default_timezone_set('America/Mexico_City');
        $zonahoraria = date_default_timezone_get();
        $Hoy = date('Y-m-d H:i:s');
        $treintadias = 86400 * 30;
        $HaceUnMesNum = strtotime($Hoy)-$treintadias;
        $HaceUnMes = date('Y-m-d H:i:s', $HaceUnMesNum);
        $bd = new database();
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $res = $bd->consultarRespuesta($Hotel, $Hoy, $HaceUnMes);
        if (isset($res[0])) {
            $datos = json_encode($res);
            echo $datos;
        }
        else{
            echo "0";
        }
        
    }
    else{
        echo "0";
    }
    
?>