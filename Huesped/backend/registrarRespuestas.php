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
    //DETERMINAR VARIABLES 
    $Habitacion = $nuevoJson->HID;
    $Respuestas = $nuevoJson->Respuestas;
    //CONSULTAR BASE DE DATOS
    $status = false;
    $ListaRespuestas = explode(":", $Respuestas);
    if (count($ListaRespuestas) == 10) {
        //Checar que sean números entre 1 y 5
        $contadorValidas = 0;
        foreach ($ListaRespuestas as $key => $Rpta) {
            if (is_numeric($Rpta)) {
                if ($Rpta > 0 && $Rpta<6 ) {
                    $contadorValidas++;
                }
            }
        }

        if ($contadorValidas == 10) {
            $consultaHabRes = $bd->consultarFecha($Habitacion, $Hoy);
            $HabResID = $consultaHabRes[0]['HabReservada_ID'];
            $status = true;
            $numPregunta = 0;
            foreach ($ListaRespuestas as $key => $Respuesta) {
                $numPregunta++;
                //Registrar respuesta
                $RES = $bd->registrarRespuesta($HabResID, $numPregunta, $Respuesta);
            }
        }
        
    }
    

    $arreglo = array('respstatus' => $status);

    
    

    //CREAR JSON PARA POSTEAR
    
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);


    
?>