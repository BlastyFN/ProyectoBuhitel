<?php 
    session_start();
    include "bdvehiculos.php";
    if (isset($_SESSION['sesionPersonal']['Hotel'])){
        $bd = new database();
        date_default_timezone_set('America/Mexico_City');
        $zonahoraria = date_default_timezone_get();
        $hoy = date('c');
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $res = $bd->consultarVehiculos($Hotel, $hoy);
        if (isset($res[0])) {
            $datos = json_encode($res);
            echo $datos;
        }
        else {
            echo 0;
        }
    }

?>