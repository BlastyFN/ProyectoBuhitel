<?php 
    include "bdHuesped.php";
    $bd = new database();
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
    $res = $bd->consultarPregunta($Hotel);
    $arreglo;
    $StringPregunta;
    if (isset($res[0])) {
        $status = true;
        $StringPregunta = $res[0]['Twilio_PreguntaAbierta'];
    }
    else{
        $StringPregunta = "¿Cuál es tu opinión en general del hotel?";
    }
    $arreglo = array(
        'prestatus' => $status,
        'pregunta' => $StringPregunta
    );
    

    //CREAR JSON PARA POSTEAR
    
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);


    
?>