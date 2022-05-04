<?php
    include "bd.php";
        
    $hotel = 1;
	$bd = new database();
    $res = $bd-> obtenerServicios($hotel);
    echo json_encode($res);


?>