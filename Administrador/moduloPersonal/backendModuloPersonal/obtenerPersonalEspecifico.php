<?php
    include "bd.php";
        
    $hotel = 1;
    $personal_id = 2;
	$bd = new database();
    $res = $bd-> obtenerPersonalEspecifico($hotel,$personal_id);
    echo json_encode($res);


?>