<?php
    include "bd.php";
    session_start();
    if(isset($_POST['reporteID'])){

        //$hotel = $_SESSION['sesionPersonal']['Hotel'];
        $hotel = 46;
        $reporte_id = $_POST['reporteID'];
        $bd = new database();
        $res = $bd-> obtenerReporteEspecifico($reporte_id);
        echo json_encode($res);

    }
?>