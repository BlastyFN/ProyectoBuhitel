<?php
include "bd.php";
if(isset($_POST['pisoID'])){
    $pisoID = $_POST['pisoID'];
	$hotel = 1;
	$bd = new database();
    $bd->eliminarHabsDePiso($pisoID);
	$res = $bd-> eliminarPiso($pisoID);
	

    echo $res;
}
?>