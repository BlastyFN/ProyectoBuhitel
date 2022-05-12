<?php
session_start();
    include "bd.php";
        $hotel =  $_SESSION['sesionPersonal']['Hotel'];
	    $bd = new database();
        $res = $bd-> obtenerPisos($hotel);
        //$res = $bd->obtenerHabs($hotel,$res);
        echo json_encode($res); 

?>