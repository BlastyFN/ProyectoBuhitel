<?php
session_start();
    include "bd.php";
    if( isset($_POST['fechaInicio']) && isset($_POST['dias']) && isset($_POST['numPregunta']) ){
        $bd = new database();
        $periodo = $_POST['dias'];
        $fechaInicio = strtotime($_POST['fechaInicio']);
        $hotel = 44;
        $numPregunta = $_POST['numPregunta'];
        $arregloRes = [];
        $condicionalHabs = $_POST['habs'];
       
        
       switch($periodo){
        case 1:
            $fechaInicio = new DateTime($_POST['fechaInicio'] . "00:00:00");
            $fechaFin = new DateTime($_POST['fechaInicio']);
            $fechaFin->modify('+24 hours');
            $puntosEncuestas = [0,0,0,0,0];
            for( $i = $fechaInicio; $i <= $fechaFin ; $i->modify('+4 hours')){
                $sumaCalificaciones = 0;
                $promedio = 0;

                $fechasqlInicio = $i->format('Y-m-d H:i:s');
                $periodo = new DateTime($i->format('Y-m-d H:i:s'));
                $periodo->modify('+ 4 hours');
                $fechasqlFin = $periodo->format('Y-m-d H:i:s');
                $resConsulta = $bd->obtenerEncuestaSalida($hotel,$fechasqlInicio, $fechasqlFin, $numPregunta, $condicionalHabs);
                foreach ($resConsulta as $item){
                    $sumaCalificaciones += intval($item['Respuesta_Valor']);
                
                }
                if(count($resConsulta) > 0){
                    $promedio = $sumaCalificaciones / count($resConsulta);
                }
                
                array_push($arregloRes,$promedio);
               
            }
           
                
            break;
        case 7:
            $fechaInicio = new DateTime($_POST['fechaInicio']);
            $fechaFin = new DateTime($_POST['fechaInicio']);
            $fechaFin->modify('+1 week');
            $puntosEncuestas = [0,0,0,0,0];
            for( $i = $fechaInicio; $i <= $fechaFin ; $i->modify('+1 day')){
                $sumaCalificaciones = 0;
                $promedio = 0;

                $fechasqlInicio = $i->format('Y-m-d');
                $periodo = new DateTime($i->format('Y-m-d'));
                $periodo->modify('+ 1 day');
                $fechasqlFin = $periodo->format('Y-m-d');
                $resConsulta = $bd->obtenerEncuestaSalida($hotel,$fechasqlInicio, $fechasqlFin, $numPregunta, $condicionalHabs);
                foreach ($resConsulta as $item){
                    $sumaCalificaciones += intval($item['Respuesta_Valor']);
                
                }
                if(count($resConsulta) > 0){
                    $promedio = $sumaCalificaciones / count($resConsulta);
                }
                
                array_push($arregloRes,$promedio);
               
            }
           
                
            break;
        case '30':
            $fechaInicio = new DateTime($_POST['fechaInicio']);
            $fechaFin = new DateTime($_POST['fechaInicio']);
            $fechaFin->modify('+1 month');
            for( $i = $fechaInicio; $i <= $fechaFin ; $i->modify('+6 days')){
                $sumaCalificaciones = 0;
                $promedio = 0;
                
                $fechasqlInicio = $i->format('Y-m-d');
                $periodo = new DateTime($i->format('Y-m-d'));
                $periodo->modify('+ 6 days');
                $fechasqlFin = $periodo->format('Y-m-d');
                $resConsulta = $bd->obtenerEncuestaSalida($hotel,$fechasqlInicio, $fechasqlFin, $numPregunta, $condicionalHabs);
                foreach ($resConsulta as $item){
                    $sumaCalificaciones += intval($item['Respuesta_Valor']);
                
                }
                if(count($resConsulta) > 0){
                    $promedio = $sumaCalificaciones / count($resConsulta);
                }
                
                array_push($arregloRes,$promedio);
               
            }
           
                
            break;
        case '365':
            $fechaInicio = new DateTime($_POST['fechaInicio']);
            $fechaFin = new DateTime($_POST['fechaInicio']);
            $fechaFin->modify('+1 year');
            $puntosEncuestas = [0,0,0,0,0];
            for( $i = $fechaInicio; $i <= $fechaFin ; $i->modify('+1 month')){
                $sumaCalificaciones = 0;
                $promedio = 0;

                $fechasqlInicio = $i->format('Y-m-d');
                $periodo = new DateTime($i->format('Y-m-d'));
                $periodo->modify('+1 month - 1 day');
                $fechasqlFin = $periodo->format('Y-m-d');
                $resConsulta = $bd->obtenerEncuestaSalida($hotel,$fechasqlInicio, $fechasqlFin, $numPregunta, $condicionalHabs);
                foreach ($resConsulta as $item){
                    $sumaCalificaciones += intval($item['Respuesta_Valor']);
                
                }
                if(count($resConsulta) > 0){
                    $promedio = $sumaCalificaciones / count($resConsulta);
                }
                
                array_push($arregloRes,$promedio);
               
            }
           
                
            break;
       } 

        
        
       
        
        echo json_encode($arregloRes);
    }

?>