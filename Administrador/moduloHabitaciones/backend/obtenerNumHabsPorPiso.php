<?php
    session_start();
    include "bd.php";
    if( isset($_POST['piso']) ){
        $piso = $_POST['piso'];
        $hotel =  $_SESSION['sesionPersonal']['Hotel'];
	    $bd = new database();
        $res = $bd->obtenerNumHabs($hotel,$piso);
        echo strval($res);
    }
?>