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
    $NHotel = null;
    $NHuesped = null;
    $NHabitacion = null;
    $HabitacionID = null;
    if (isset($res[0])) {
        $status = true;
        $NHotel = $res[0]['Hotel_Nombre'];
        $NHuesped = $res[0]['Huesped_Nombre'];
        $NHabitacion = $res[0]['Habitacion_Nombre'];
        $HabitacionID = $res[0]['Habitacion_ID'];
        $HotelID = $bd->consultarHotel($HabitacionID);
        $res2 = $bd->consultarStatusTwilio("Twilio_ChatBot", $HotelID);
        if ($res2[0][0] == "0") {
            $status = "disabled";
        }
    }
    
    //CREAR JSON PARA POSTEAR
    $arreglo = array(
        'registrado' => $status,
        'Hotel' => $NHotel,
        'Huesped' => $NHuesped,
        'Habitacion' => $NHabitacion,
        'HID' => $HabitacionID
    );
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);

?>