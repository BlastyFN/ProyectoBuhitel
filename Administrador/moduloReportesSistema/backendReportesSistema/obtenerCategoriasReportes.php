<?php
session_start();
    include "bd.php";
 
    $bd = new database();
    $hotel = $_SESSION['sesionPersonal']['Hotel'];
    $arregloRes = $bd->obtenerCategoriaReportes($hotel); 
    echo json_encode($arregloRes);

?>