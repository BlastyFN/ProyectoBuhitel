<?php 
    session_start();
    include "bdservicios.php";
    if (isset($_SESSION['sesionPersonal']['Hotel']) && isset($_POST['Estatus']) && isset($_POST['Servicio'])){
        $bd = new database();
        $Estatus = $_POST['Estatus'];
        $Servicio = $_POST['Servicio'];
        $res = $bd->actualizarEstatus($Servicio, $Estatus);
        echo $Estatus;
    }

?>