<?php 
    session_start();
    include "bdservicios.php";
    if (isset($_SESSION['sesionPersonal']['Hotel']) && isset($_POST['Servicio']) && isset($_POST['Precio'])){
        $bd = new database();
        date_default_timezone_set('America/Mexico_City');
        $zonahoraria = date_default_timezone_get();
        $Hoy = date('Y-m-d H:i:s');
        $Servicio = $_POST['Servicio'];
        $Precio = $_POST['Precio'];
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $res = $bd->actualizarServicio($Hotel, $Servicio, $Hoy, $Precio);
        echo $res;
    }

?>