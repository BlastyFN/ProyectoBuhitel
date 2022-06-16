<?php
session_start();
    include "bd.php";
        $hotel =  $_SESSION['sesionPersonal']['Hotel'];
	    $bd = new database();
        $res = $bd-> obtenerPisos($hotel);
        echo json_encode($res); 

?>