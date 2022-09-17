<?php
    session_start();
    include "bd.php";
    date_default_timezone_set('America/Mexico_City');
    $zonahoraria = date_default_timezone_get();
    $hoy = date('c');
    $hotel = $_SESSION['sesionPersonal']['Hotel'];
	$bd = new database();
    $res = $bd->obtenerHabsDesocupadas($hotel);
    
    $res2 = $bd->obtenerReservaciones($hotel, $hoy);
    if ($res2>0) {
        $num =  $res - $res2;
    }
    else{
        $num = $res;
    }
    echo strval($num);
    
?>