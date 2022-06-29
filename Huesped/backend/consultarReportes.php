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
    $Hotel = $bd->consultarHotel($Habitacion);
    $res = $bd->consultarReportes($Habitacion, $Hoy);
    $arreglo;
    if (isset($res[0])) {
        $status = true;
        $contador = 0;
        $StringReportes="Reportes: \n";
        foreach ($res as $key => $rep) {
            $contador++;
            $StringReportes = $StringReportes . $contador . ".- " . " Nombre: ".$rep['Reporte_Nombre'] . " Estado: ".$rep['EstatusReporte_Estatus']. "\n";
        }
        $arreglo = array(
            'repstatus' => $status,
            'reportes' => $StringReportes
        );
    }
    else{
        $arreglo = array('repstatus' => $status);
    }
    
    

    //CREAR JSON PARA POSTEAR
    
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);


    
?>