<?php
    include "bd.php";
    session_start();
    if (isset($_POST['reporteID']) && isset($_POST['servicio']) && isset($_POST['personal'])){

        $hotel = $_SESSION['sesionPersonal']['Hotel'];
        //$hotel = 46;
        $personal = $_POST['personal'];
        $servicio = $_POST['servicio'];
        $reporte = $_POST['reporteID'];   
        $bd = new database();
        date_default_timezone_set('America/Mexico_City');
        $zonahoraria = date_default_timezone_get();
        $Hoy = date('Y-m-d H:i:s');

        $res = $bd-> asignarSeguimiento($personal,$servicio,$reporte,$hoy);
        echo json_encode($res);

    }

       
    
?>