<?php
include "bd.php";
session_start();
if(isset($_POST['piso'])){
    $piso = $_POST['piso'];
	$hotel =  $_SESSION['sesionPersonal']['Hotel'];
	$bd = new database();
	$res = $bd-> registrarPiso($piso, $hotel);
	$pisoID = $bd->obtenerPisoID($piso, $hotel);

    echo $pisoID;
}
?>