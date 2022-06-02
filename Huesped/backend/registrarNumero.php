<?php 
    include "bdHuesped.php";
    $bd = new database();
    //FECHAS
    date_default_timezone_set('America/Mexico_City');
    $zonahoraria = date_default_timezone_get();
    $hoy = date('Y-m-d');
    //INIT
    header('Content-Type: application/json;');
    $info = file_get_contents('php://input');
    //Hacer JSON
    $nuevoJson = json_decode($info);
    //DETERMINAR NUMERO
    $cuentaWPP = $nuevoJson->numero;
    $numero = substr($cuentaWPP, 10);
    //OBTENER CODIGO 
    $codigo = $nuevoJson->codigo;
    //CONSULTAR BASE DE DATOS
    $res = $bd->consultarCodigo($codigo);
    $HID;
    if (count($res) > 0)
    {
        foreach ($res as $dato)
        $HID = $dato['HabReservada_ID'];
    }
    $res2 = $bd->registrarNumero($numero, $HID);
?>