<?php
    session_start();
    include "bd.php";
    date_default_timezone_set('America/Mexico_City');
    $zonahoraria = date_default_timezone_get();
    $hoy = date('H:i:s');
    $hotel = $_SESSION['sesionPersonal']['Hotel'];
	$bd = new database();
    $res = $bd->obtenerPersonalTrabajando($hotel, $hoy);

    echo strval($res);
    
?>