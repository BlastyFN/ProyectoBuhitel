<?php
include "bdPrincipal.php";

if(isset($_POST['hotel'])){
	$res = 0;
	$hotel = $_POST['hotel'];
	$bd = new database();
    
	$res = $bd->obtenerPisos($hotel);
    echo $res;
}
?>