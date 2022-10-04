<?php 
    include "bdHuesped.php";
    $bd = new database();
    //FECHAS
    date_default_timezone_set('America/Mexico_City');
    $zonahoraria = date_default_timezone_get();
    $Hoy = date('Y-m-d H:i:s');
    //INIT
    header('Content-Type: application/json;');
    $info = file_get_contents('php://input');
    //Hacer JSON
    $nuevoJson = json_decode($info);
    //DETERMINAR VARIABLES 
    $Habitacion = $nuevoJson->HID;
    $Respuesta = $nuevoJson->Abierta;
    //CONSULTAR BASE DE DATOS
    $status = false;
    $consultaHabRes = $bd->consultarFecha($Habitacion, $Hoy);
    $HabResID = $consultaHabRes[0]['HabReservada_ID'];
    $status = true;
    $numPregunta = 11;
    $RES = $bd->registrarRespuesta($HabResID, $numPregunta, $Respuesta);
    $arreglo = array('respstatus' => $status);

    
    

    //CREAR JSON PARA POSTEAR
    
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);


    
?>