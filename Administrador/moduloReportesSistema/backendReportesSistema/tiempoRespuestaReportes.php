<?php
session_start();
    include "bd.php";
    $arregloRes = array();
    $bd = new database();
    $hotel = $_SESSION['sesionPersonal']['Hotel'];
    $condicionalHabs = $_POST['habs'];
    for($i = 2; $i <= 14; $i+=2){
        $resConsulta = 0;
        $resConsulta = $bd->obtenerTiempoOcupaciones($hotel, $i, $condicionalHabs);
        array_push($arregloRes, $resConsulta);
    }
    
    echo json_encode($arregloRes);

?>