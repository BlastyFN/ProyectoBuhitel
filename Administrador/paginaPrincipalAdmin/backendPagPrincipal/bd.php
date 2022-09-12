<?php
class database
{
	
	private $con;

	function __construct(){
		$this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022'); //'corpo206_gestorbuhi','ProyectoBuhitel2022'
	}



	function obtenerHabsDesocupadas($hotel){
		$sql = $this->con->prepare("SELECT Habitacion_ID FROM habitacion INNER JOIN piso ON piso.Piso_ID 
		= Habitacion_Piso WHERE piso.Piso_Hotel = '".$hotel."' AND Habitacion_Estado = 1");
		$sql->execute();
		$res = $sql->fetchall();
		return count($res);
	}

	function obtenerReservaciones($hotel, $hoy){
		$sql = $this->con->prepare("SELECT HabReservada_ID FROM habitacionreservada 
		INNER JOIN reservacion ON reservacion.Reservacion_ID = HabReservada_Reservacion
		INNER JOIN habitacion ON habitacion.Habitacion_ID = HabReservada_Habitacion
		INNER JOIN piso ON piso.Piso_ID = habitacion.Habitacion_Piso
		WHERE BINARY '".$hoy."' BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut
		AND BINARY piso.Piso_Hotel = '".$hotel."'");
		$sql->execute();
		$res = $sql->fetchall();
		return count($res);
	}

	function obtenerNumReportes($hotel){
		$sql = $this->con->prepare("SELECT * FROM reporte INNER JOIN habitacionreservada ON 
		Reporte_HabReservadas = habitacionreservada.HabReservada_ID INNER JOIN habitacion ON 
		habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID INNER JOIN piso ON 
		habitacion.Habitacion_Piso = piso.Piso_ID WHERE piso.Piso_Hotel = '".$hotel."' AND
		reporte.Reporte_Estatus != 5");
		$sql->execute();
		$res = $sql->fetchall();
		return count($res);
	}


}

?>