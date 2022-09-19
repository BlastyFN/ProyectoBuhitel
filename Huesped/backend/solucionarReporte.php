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
    $NumRep = $nuevoJson->Numero;
    $Num = $NumRep-1;
    //CONSULTAR BASE DE DATOS
    $status = false;
    $resR = $bd->consultarReportes($Habitacion, $Hoy);
    if (isset($resR[$Num])) {
        $status = $bd->solucionarReporte($resR[$Num]['Reporte_ID']);
    }

    //CREAR JSON PARA POSTEAR
    $arreglo = array(
        'statrep' => $status,
    );
    $JSONSTATUS = json_encode($arreglo);
    print_r($JSONSTATUS);


    
?>