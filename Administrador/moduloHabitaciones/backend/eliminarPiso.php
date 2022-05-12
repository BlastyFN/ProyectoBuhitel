<?php
session_start();
include "bd.php";
if(isset($_POST['pisoID'])){
    $pisoID = $_POST['pisoID'];
	$hotel = $_SESSION['sesionPersonal']['Hotel'];
	$bd = new database();
    $bd->eliminarHabsDePiso($pisoID);
	$res = $bd-> eliminarPiso($pisoID);
	

    echo $res;
}
?>