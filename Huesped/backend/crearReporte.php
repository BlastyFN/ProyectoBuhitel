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
    $Categoria = $nuevoJson->Categoria;
    $Nombre = $nuevoJson->Nombre;
    $Cuerpo = $nuevoJson->Cuerpo;
    //CONSULTAR BASE DE DATOS
    $HabReservada = $bd->consultarHabReservada($Habitacion, $Hoy);
    $status = false;
    $status = $bd->crearReporte($HabReservada, $Categoria, $Nombre, $Cuerpo);
    $arreglo = array('statrep' => $status);
    //CREAR JSON PARA POSTEAR
    
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);


    
?> 