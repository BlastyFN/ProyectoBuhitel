<?php 
    session_start();
    include "bdservicios.php";
    if (isset($_SESSION['sesionPersonal']['Hotel']) && isset($_POST['Habitacion']) && isset($_POST['Precio'])){
        $bd = new database();
        date_default_timezone_set('America/Mexico_City');
        $zonahoraria = date_default_timezone_get();
        $Hoy = date('Y-m-d H:i:s');
        $Habitacion = $_POST['Habitacion'];
        $Precio = $_POST['Precio'];
        $res = $bd->registrarServicio($Habitacion, $Hoy, $Precio);
        echo $res;
    }

?>