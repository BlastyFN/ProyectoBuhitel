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
    $resLP = $bd->consultarLimpiezasPendientes($Hoy, $Habitacion);
    $StringLP = "No hay limpiezas pendientes";
    $StringLEC ="No hay limpiezas en curso";
    if (isset($resLP[0])) {
        $StringLP = "Limpiezas pendientes: \n";
        foreach ($resLP as $key => $limpieza) {
            $num = $key+1;
            $StringLP = $StringLP.$num.".- De: ".$limpieza['Limpieza_HoraInicio']." A: ".$limpieza['Limpieza_HoraFin']."\n"; 
        }
    }
    $resLEC = $bd->consultarLimpiezasEnCurso($Hoy, $Habitacion);
    if (isset($resLEC[0])) {
        $StringLEC = "Limpiezas en curso: \n";
        foreach ($resLEC as $key => $limpieza) {
            $num = $key+1;
            $StringLEC = $StringLEC.$num.".- De: ".$limpieza['Limpieza_HoraInicio']." A: ".$limpieza['Limpieza_HoraFin']."\n"; 
        }
    }
    $status = true;

    
    

    //CREAR JSON PARA POSTEAR
    $arreglo = array(
        'statlimp' => $status,
        'pendientes' => $StringLP,
        'actuales' => $StringLEC
    );
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);


    
?>