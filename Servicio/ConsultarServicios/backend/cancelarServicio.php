<?php 
    session_start();
    include "bdservicios.php";
    if (isset($_SESSION['sesionPersonal']['Hotel']) && isset($_POST['Servicio'])){
        $bd = new database();
        $Servicio = $_POST['Servicio'];
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $res = $bd->cancelarServicio($Hotel, $Servicio);
        echo $res;
    }

?>