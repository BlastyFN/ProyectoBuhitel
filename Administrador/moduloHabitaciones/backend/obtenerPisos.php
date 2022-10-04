<?php
session_start();
    include "bd.php";
        $hotel =  $_SESSION['sesionPersonal']['Hotel'];
	    $bd = new database();
        $pisos = $bd-> obtenerPisos($hotel);
        foreach ($pisos as $piso) {
            $habs = $bd->obtenerHabs($hotel, $piso['piso_ID']);
            $piso->habs = $habs;
        }
        echo json_encode($pisos); 

?>