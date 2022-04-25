<?php 
    session_start();
    include "bdservicios.php";
    if (isset($_SESSION['sesionPersonal']['Hotel']) && isset($_POST['Habitacion'])){
        $bd = new database();
        date_default_timezone_set('America/Mexico_City');
        $zonahoraria = date_default_timezone_get();
        $hoy = date('c');
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $Habitacion = $_POST['Habitacion'];
        $res = $bd->consultarVehiculo($Hotel, $hoy, $Habitacion);
        if (isset($res[0])) {
            $datos = json_encode($res[0]);
            echo $datos;
        }
        else {
            echo 0;
        }
    }

?>