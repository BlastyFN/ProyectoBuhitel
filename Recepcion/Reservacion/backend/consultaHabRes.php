<?php 
    session_start();
    include "bdReservacion.php";
    if (isset($_SESSION['sesionPersonal'])) {
        date_default_timezone_set('America/Mexico_City');
        $zonahoraria = date_default_timezone_get();
        $hoy = date('Y-m-d');
        $bd = new database();
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $res = $bd->consultaHabRes($Hotel, $hoy);
        if (isset($res[0])) {
            $datos = json_encode($res);
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