<?php
    include "bd.php";
        
    $hotel = 1;
	$bd = new database();
    $res = $bd-> obtenerPersonal($hotel);
    echo json_encode($res);


?>