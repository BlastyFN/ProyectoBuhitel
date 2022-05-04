<?php
    include "bd.php";
        $hotel = 1;
	    $bd = new database();
        $res = $bd-> obtenerPisos($hotel);
        //$res = $bd->obtenerHabs($hotel,$res);
        echo json_encode($res); 

?>