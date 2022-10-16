<?php
    include "bd.php";
    session_start();
    $hotel = $_SESSION['sesionPersonal']['Hotel'];
   
    $idReporte = $_POST["reporteID"];

    $bd = new database();
    $bd->marcarReporteVisto($idReporte);
    

?>

<?