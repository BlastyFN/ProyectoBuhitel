<?php 
    include "bdHuesped.php";
    $bd = new database();
    //FECHAS
    date_default_timezone_set('America/Mexico_City');
    $zonahoraria = date_default_timezone_get();
    $Hoy = date('Y-m-d H:i:s');
    $diaHoy = date('Y-m-d');
    //INIT
    header('Content-Type: application/json;');
    $info = file_get_contents('php://input');
    //Hacer JSON
    $nuevoJson = json_decode($info);
    //DETERMINAR CODIGO 
    $Habitacion = $nuevoJson->HID;
    //CONSULTAR BASE DE DATOS
    $status = false;
    $consultaFecha = $bd->consultarFecha($Habitacion, $Hoy);
    if (isset($consultaFecha[0]['Reservacion_CheckOut'])) {
        $fecha = $consultaFecha[0]['Reservacion_CheckOut'];
        $partesFecha = explode(" ", $fecha);
        $DiaCOUT = $partesFecha[0];
        if ($DiaCOUT == $diaHoy) {
            $status = true;
        }
    }
    
    $arreglo = array('coutstatus' => $status,
                    'fechaCOUT' => $fecha,
                    'fechaHoy' => $diaHoy
);
    //CREAR JSON PARA POSTEAR
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);


    
?>