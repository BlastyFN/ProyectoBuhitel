<?php
    include "bd.php";
    session_start();
    $hotel = $_SESSION['sesionPersonal']['Hotel'];
   
    $idReporte = $_POST["reporte"];

    $bd = new database();
    $bd->completarReporte($idReporte);
    

?>

<?