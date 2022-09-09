<?php
class database
{
	
	private $con;

	function __construct(){
		$this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022'); //'corpo206_gestorbuhi','ProyectoBuhitel2022'
	}



	function obtenerHabsDesocupadas($hotel){
		$sql = $this->con->prepare("SELECT Habitacion_ID FROM habitacion INNER JOIN piso ON piso.Piso_ID 
		= Habitacion_Piso WHERE piso.Piso_Hotel = '".$hotel."' AND Habitacion_Estado = 0");
		$sql->execute();
		$res = $sql->fetchall();
		return count($res);
	}

	function obtenerNumReportes($hotel){
		$sql = $this->con->prepare("SELECT * FROM reporte INNER JOIN habitacionreservada ON 
		Reporte_HabReservadas = habitacionreservada.HabReservada_ID INNER JOIN habitacion ON 
		habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID INNER JOIN piso ON 
		habitacion.Habitacion_Piso = piso.Piso_ID WHERE piso.Piso_Hotel = 44 AND
		reporte.Reporte_Estatus != 8");
		$sql->execute();
		$res = $sql->fetchall();
		return count($res);
	}


}

?>