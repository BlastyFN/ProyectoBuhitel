<?php
    include "bd.php";
    session_start();
    $hotel = $_SESSION['sesionPersonal']['Hotel'];
   
    $idReporte = $_POST["reporte"];
    date_default_timezone_set('America/Mexico_City');
    $zonahoraria = date_default_timezone_get();
    $Hoy = date('Y-m-d H:i:s');

    $bd = new database();
    $bd->completarReporte($idReporte,$Hoy);
    

?>
