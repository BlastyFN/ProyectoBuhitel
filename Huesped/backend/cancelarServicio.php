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
    //DETERMINAR CODIGO 
    $Habitacion = $nuevoJson->HID;
    $NumSer = $nuevoJson->Numero;
    $Num = $NumSer-1;
    //CONSULTAR BASE DE DATOS
    $status = false;
    $resSP = $bd->consultarServicios($Hoy, $Habitacion, 1);
    if (isset($resSP[$Num])) {
        $status = $bd->cancelarServicio($resSP[$Num]['Servicio_ID']);
    }

    //CREAR JSON PARA POSTEAR
    $arreglo = array(
        'statcans' => $status,
    );
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);


    
?>