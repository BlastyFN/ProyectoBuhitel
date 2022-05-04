<?php
    include "bd.php";

    $hotel = 1;
	$bd = new database();
    $res = $bd-> obtenerTiposHabs($hotel);
    
    echo json_encode($res);


?>