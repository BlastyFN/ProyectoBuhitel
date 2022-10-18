<?php
    include "bd.php";
    session_start();
    $hotel = $_SESSION['sesionPersonal']['Hotel'];
    $nombreCat = $_POST["nombre"];
    $idReporte = $_POST["reporte"];

    date_default_timezone_set('America/Mexico_City');
    $zonahoraria = date_default_timezone_get();
    $Hoy = date('Y-m-d H:i:s');

    $bd = new database();
    $idCategoria = $bd->obtenerCategoriaID($hotel,$nombreCat);
    $bd->marcarComoSpam($idCategoria,$idReporte);
    
    $bd->completarReporte($idReporte,$Hoy);

?>