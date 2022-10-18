<?php
session_start();
    include "bd.php";
    $arregloRes = array();
    $bd = new database();
    $hotel = $_SESSION['sesionPersonal']['Hotel'];
    $condicionalHabs = $_POST['habs'];
    for($i = 5; $i <= 35; $i+=5){
        $resConsulta = 0;
        $resConsulta = $bd->tiempoRespuestaReportes($hotel, $i, $condicionalHabs);
        array_push($arregloRes, $resConsulta);
    }
    
    echo json_encode($arregloRes);

?>