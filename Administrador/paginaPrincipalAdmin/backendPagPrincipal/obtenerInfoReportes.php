<?php
    session_start();
    include "bd.php";

    $hotel = $_SESSION['sesionPersonal']['Hotel'];
	$bd = new database();
    $res = $bd->obtenerNumReportes($hotel);
    echo strval($res);
    
?>