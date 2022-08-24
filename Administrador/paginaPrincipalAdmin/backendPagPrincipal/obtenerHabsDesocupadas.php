<?php
    session_start();
    include "bd.php";

    $hotel = 46 ;//$_SESSION['sesionPersonal']['Hotel'];
	$bd = new database();
    $res = $bd->obtenerHabsDesocupadas($hotel);
    echo strval($res);
    
?>