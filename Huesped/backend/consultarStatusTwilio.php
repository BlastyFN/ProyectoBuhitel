<?php 
    include "bdHuesped.php";
    $bd = new database();
    //FECHAS
    date_default_timezone_set('America/Mexico_City');
    $zonahoraria = date_default_timezone_get();
    $Hoy = date('c');
    //INIT
    header('Content-Type: application/json;');
    $info = file_get_contents('php://input');
    //Hacer JSON
    $nuevoJson = json_decode($info);
    //DETERMINAR CODIGO 
    $Campo = $nuevoJson->Campo;
    $Habitacion = $nuevoJson->HID;
    //CONSULTAR BASE DE DATOS
    $Hotel = $bd->consultarHotel($Habitacion);

    $status = false;
    $res = $bd->consultarStatusTwilio($Campo, $Hotel);
    if ($res[0][0] == '1') {
        $status = true;
    }
    
    

    //CREAR JSON PARA POSTEAR
    $arreglo = array('habilitado' => $status);
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);


    
?>