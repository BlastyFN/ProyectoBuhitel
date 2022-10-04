<?php
session_start();
    include "bd.php";
        $hotel =  $_SESSION['sesionPersonal']['Hotel'];
	    $bd = new database();
        $pisos = $bd-> obtenerPisos($hotel);
        for($contPisos = 0; $contPisos < count($pisos); $contPisos++){
            $habs = $bd->obtenerHabs($hotel, $pisos[$contPisos]['piso_ID']);
            array_push($pisos[$contPisos],$habs);
        }
        echo json_encode($pisos); 

?>