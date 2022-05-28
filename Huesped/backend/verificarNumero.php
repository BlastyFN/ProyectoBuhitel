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
    //CONSULTAR BASE DE DATOS
    $res = $bd->consultarSesion($numero, $hoy);
    $status = false;
    if (isset($res[0])) {
        $status = true;
    }
    //CREAR JSON PARA POSTEAR
    $arreglo = array('numero' => $status);
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);

    // var_dump($nuevoJson);
    // var_dump($numero);
    
    
?>