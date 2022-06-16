<?php
include "bd.php";
session_start();
if(isset($_POST['pisos']) &&  isset($_POST['numHabs'])){
	$pisos = $_POST['pisos'];
	$numHabs = json_decode($_POST['numHabs']);
	

	$hotel = $_SESSION['sesionPersonal']['Hotel'];
	$bd = new database();
	$TipoHabID = $bd->obtenerTipoHabID($hotel,"Individual");

	for($cont = 0; $cont < $pisos; $cont++){ //Piso por iteración
		$piso = $cont + 1;
		$res = $bd-> registrarPiso($piso, $hotel);

		$habsPorPiso = $numHabs[$cont];
		//echo $habsPorPiso;
		$pisoID = $bd->obtenerPisoID($piso,$hotel);

		for($contHabs = 0; $contHabs < $habsPorPiso; $contHabs++){ //Definir todas las habitaciones de cada piso
			$nombreHab = $piso * 100 + $contHabs + 1;
			$bd->registrarHab($nombreHab,$pisoID,$TipoHabID);
		}	
	}
}
?>