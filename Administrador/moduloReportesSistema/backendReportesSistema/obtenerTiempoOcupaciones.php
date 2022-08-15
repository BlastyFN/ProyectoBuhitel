<?php
session_start();
    include "bd.php";
 
    $bd = new database();
    $hotel = 44;
    $arregloRes = [];
    for($i = 0; $i < 14; $i+=2){
        $resConsulta = $bd->obtenerTiempoOcupaciones($hotel, $i,$i+2);
        array_push($arregloRes, $resConsulta);
    }
    
    echo json_encode($arregloRes);

?>