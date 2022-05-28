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
    //DETERMINAR CODIGO 
    $codigo = $nuevoJson->codigo;
    //CONSULTAR BASE DE DATOS
    $status = "invalido";
    if (strlen($codigo) == 6) {
        $status = false;
        $res = $bd->consultarCodigo($codigo);
        if (isset($res[0])) {
            $status = true;
        }
    }
    

    //CREAR JSON PARA POSTEAR
    $arreglo = array('verificado' => $status);
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);


    
?>