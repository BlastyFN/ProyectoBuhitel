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
    $CatNum = $nuevoJson->Numero;
    //CONSULTAR BASE DE DATOS
    $status = false;
    $Hotel = $bd->consultarHotel($Habitacion);
    $res = $bd->consultarCategoriasReportes($Hotel);
    $id = null;
    $arreglo;
    if (isset($res[$CatNum-1])) {
        $id = $res[$CatNum-1]['CatReporte_ID'];
        $status = true;
        $arreglo = array(
            'existenciaCR' => $status,
            'catrepID' => $id
        );
    }
    else{
        $arreglo = array('existenciaCR' => $status);
    }


    //CREAR JSON PARA POSTEAR
    
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);


    
?> 