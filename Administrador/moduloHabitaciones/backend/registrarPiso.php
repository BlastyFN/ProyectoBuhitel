<?php
include "bd.php";
if(isset($_POST['piso'])){
    $piso = $_POST['piso'];
	$hotel = 1;
	$bd = new database();
	$res = $bd-> registrarPiso($piso, $hotel);
	$pisoID = $bd->obtenerPisoID($piso, $hotel);

    echo $pisoID;
}
?>