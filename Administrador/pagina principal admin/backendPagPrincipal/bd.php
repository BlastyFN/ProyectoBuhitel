<?php
class database
{
	
	private $con;

	function __construct(){
		$this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','root',''); //'corpo206_gestorbuhi','ProyectoBuhitel2022'
	}



	function obtenerHabsDesocupadas($hotel){
		$sql = $this->con->prepare("SELECT Habitacion_ID FROM habitacion INNER JOIN piso ON piso.Piso_ID = Habitacion_Piso WHERE piso.Piso_Hotel = '".$hotel."' AND Habitacion_Estado = 0");
		$sql->execute();
		$res = $sql->fetchall();
		return count($res);
	}

	

}

?>