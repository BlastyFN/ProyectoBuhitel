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
    $status = 0;
    $res = $bd->consultarVehiculo($Hoy, $Habitacion);
    if (isset($res[0])) {
        $status = 1;
        if ($res[0]['Vehiculo_Estatus'] == 1) {
            $status = 2;
        }
    }
    
    

    //CREAR JSON PARA POSTEAR
    $arreglo = array('statveh' => $status);
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);


    
?>