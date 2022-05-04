<?php
    include "bd.php";
    if( isset($_POST['piso']) ){
        $piso = $_POST['piso'];
        $hotel = 1;
	    $bd = new database();
        $res = $bd->obtenerHabs($hotel,$piso);
        echo json_encode($res);
    }
?>