<?php
session_start();
    include "bd.php";
    if( isset($_POST['fechaInicio']) && isset($_POST['dias'])){
        $bd = new database();
        $periodo = $_POST['dias'];
        $fechaInicio = strtotime($_POST['fechaInicio']);
        $hotel = $_SESSION['sesionPersonal']['Hotel'];
        $arregloRes = array();
        $condicionalHabs = $_POST['habs'];
        
       switch($periodo){
        case 1:
            $fechaInicio = new DateTime($_POST['fechaInicio'] . "00:00:00");
            $fechaFin = new DateTime($_POST['fechaInicio']);
            $fechaFin->modify('+24 hours');
            for( $i = $fechaInicio; $i <= $fechaFin ; $i->modify('+4 hours')){
                $fechasqlInicio = $i->format('Y-m-d H:i:s');
                $periodo = new DateTime($i->format('Y-m-d H:i:s'));
                $periodo->modify('+ 4 hours');
                $fechasqlFin = $periodo->format('Y-m-d H:i:s');
                $resConsulta = $bd->obtenerInfoGeneralServicio($fechasqlInicio, $fechasqlFin, $hotel, $condicionalHabs);
                $resConsulta += $bd->obtenerIngresosPorEstancia($fechasqlInicio, $fechasqlFin, $hotel, $condicionalHabs);
                
                array_push($arregloRes,$resConsulta);
            }    
            break;
        case 7:
            $fechaFin = strtotime($_POST['fechaInicio']) + 86400 * $periodo;
            for($i = $fechaInicio; $i <= $fechaFin; $i+=86400){
                $fechasqlInicio = date("Y-m-d", $i);
                $fechasqlFin = date("Y-m-d", $i+86400);
                $resConsulta = $bd->obtenerInfoGeneralServicio($fechasqlInicio, $fechasqlFin, $hotel, $condicionalHabs);
                $resConsulta += $bd->obtenerIngresosPorEstancia($fechasqlInicio, $fechasqlFin, $hotel, $condicionalHabs);
                array_push($arregloRes,$resConsulta);
               
            }
            break;
        case '30':
            $fechaInicio = new DateTime($_POST['fechaInicio']);
            $fechaFin = new DateTime($_POST['fechaInicio']);
            $fechaFin->modify('+1 month');
            for( $i = $fechaInicio; $i <= $fechaFin ; $i->modify('+6 days')){
                $fechasqlInicio = $i->format('Y-m-d');
                $periodo = new DateTime($i->format('Y-m-d'));
                $periodo->modify('+ 6 days');
                $fechasqlFin = $periodo->format('Y-m-d');
                $resConsulta = $bd->obtenerInfoGeneralServicio($fechasqlInicio, $fechasqlFin, $hotel, $condicionalHabs);
                $resConsulta += $bd->obtenerIngresosPorEstancia($fechasqlInicio, $fechasqlFin, $hotel, $condicionalHabs);
                array_push($arregloRes,$resConsulta);
            }
                
            break;
        case '365':
            $fechaInicio = new DateTime($_POST['fechaInicio']);
            $fechaFin = new DateTime($_POST['fechaInicio']);
            $fechaFin->modify('+1 year');
            for( $i = $fechaInicio; $i <= $fechaFin ; $i->modify('+1 month')){
                $fechasqlInicio = $i->format('Y-m-d');
                $periodo = new DateTime($i->format('Y-m-d'));
                $periodo->modify('+1 month - 1 day');
                $fechasqlFin = $periodo->format('Y-m-d');
                $resConsulta = $bd->obtenerInfoGeneralServicio($fechasqlInicio, $fechasqlFin, $hotel, $condicionalHabs);
                $resConsulta += $bd->obtenerIngresosPorEstancia($fechasqlInicio, $fechasqlFin, $hotel, $condicionalHabs);
                array_push($arregloRes,$resConsulta);
                
            }
            
            break;
       } 

        
        
       
 
        echo json_encode($arregloRes);
    }

?>