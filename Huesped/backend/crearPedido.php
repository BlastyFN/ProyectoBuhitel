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
    //CONSULTAR BASE DE DATOS
    $status = false;
    $PID = $bd->crearPedido($Habitacion, $Hoy);
    $arreglo;
    if ($PID!=null) {
        $status = true;
        $contador = 0;
        $arreglo = array(
            'pedstatus' => $status,
            'PID' => $PID
        );
    }
    else{
        $arreglo = array('pedstatus' => $status);
    }
    
    

    //CREAR JSON PARA POSTEAR
    
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);


    
?>