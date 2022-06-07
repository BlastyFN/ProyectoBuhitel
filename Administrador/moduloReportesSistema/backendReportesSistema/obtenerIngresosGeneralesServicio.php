<?php
session_start();
    include "bd.php";

        $bd = new database();
        $fechaInicio = strtotime("2022-06-03");
        $fechaFin = strtotime("2022-06-09");
        $arregloRes = array();
        
        

        
        for($i = $fechaInicio; $i <= $fechaFin; $i+=86400){
            $fechasqlInicio = date("Y-m-d", $i);
            $fechasqlFin = date("Y-m-d", $i+86400);
            $resConsulta = $bd->obtenerInfoGeneralServicio($fechasqlInicio, $fechasqlFin);
            array_push($arregloRes,$resConsulta);
           
        }
       

        var_dump($arregloRes);-
    

?>