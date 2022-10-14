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
    $resCarg = $bd->consultarCargos($Hoy, $Habitacion);
    $StringCargos = "No hay cargos adicionales";
    if (isset($resCarg[0])) {
        $StringCargos = "Cargos: \n";
        foreach ($resCarg as $key => $cargo) {
            $num = $key+1;
            $StringCargos = $StringCargos.$num.".- $".$cargo['Cargo_Monto']." por concepto de ".$cargo['Cargo_Concepto']."\n"; 
        }
    }
    $status = true;

    
    

    //CREAR JSON PARA POSTEAR
    $arreglo = array(
        'statlimp' => $status,
        'cargos' => $StringCargos
    );
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);


    
?>