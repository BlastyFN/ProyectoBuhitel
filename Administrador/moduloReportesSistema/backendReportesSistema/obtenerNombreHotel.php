<?php
session_start();
    include "bd.php";
 
    $bd = new database();
    $hotel = 46; 
    $arregloRes = $bd->obtenerNombreHotel($hotel); 
    echo json_encode($arregloRes);

?>