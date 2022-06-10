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
    $Habitacion = $nuevoJson->HID;
    //CONSULTAR BASE DE DATOS
    $status = false;
    $res = $bd->consultarVehiculo($Hoy, $Habitacion);
    if (isset($res[0])) {
        $Placas = $res[0]['Vehiculo_Placas'];
        $re2 = $bd->solicitudVehiculo($Placas, '0');
        $status = $re2;
    }
    
    

    //CREAR JSON PARA POSTEAR
    $arreglo = array('canvalet' => $status);
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);


    
?>