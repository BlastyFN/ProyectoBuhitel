<?php
    include "bd.php";
    include "../../../Recursos/Twilio/buhi.php";
    session_start();
    $hotel = $_SESSION['sesionPersonal']['Hotel'];
    $Categoria = $_POST["Categoria"];
    $Reporte = $_POST["Reporte"];
    $bd = new database();
    $bd->marcarComoSpam($Reporte, $Categoria);
    
?>