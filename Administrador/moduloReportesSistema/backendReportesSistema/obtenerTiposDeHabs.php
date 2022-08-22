<?php
    include "bd.php";
    session_start();
    $hotel =  44;//$_SESSION['sesionPersonal']['Hotel'];
	$bd = new database();
    $res = $bd-> obtenerTiposHabs($hotel);
    
    echo json_encode($res);


?>