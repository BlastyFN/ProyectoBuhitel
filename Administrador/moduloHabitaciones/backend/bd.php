<?php
class database
{
	
	private $con;

	function __construct(){
		$this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022');
	}

    function registrarPiso($piso, $hotel){
		$sqltest = $this->con->prepare("SELECT * FROM piso WHERE Piso_Numero = '".$piso."' AND Piso_Hotel = '".$hotel."'");
		$sqltest->execute();
		$res = $sqltest->fetchall();
		if (count($res) < 1){
			$sql = $this->con->prepare( "INSERT INTO piso (Piso_Numero, Piso_Hotel) 
	    	VALUES ('".$piso."','".$hotel."')" );
	    	$sql->execute();
    	}
		return "se ha realizado con exito la configuración";
	}


	

	function obtenerTipoHabID($hotel,$nombre){
		$sql = $this->con->prepare("SELECT * FROM tipohabitacion WHERE TipoHab_Hotel = '".$hotel."' AND TipoHab_Nombre = '".$nombre."'");
		$sql->execute();
		$res = $sql->fetchall();
		if (count($res) > 0)
		{
			foreach ($res as $dato)
			return $dato['TipoHab_ID'];
		}
		return -1;
	}

	function obtenerPrimerTipoHabID($hotel){
		$sql = $this->con->prepare("SELECT * FROM tipohabitacion WHERE TipoHab_Hotel = '".$hotel."'");
		$sql->execute();
		$res = $sql->fetchall();
		if (count($res) > 0)
		{
			foreach ($res as $dato)
			return $dato['TipoHab_ID'];
		}
		return -1;
	}

	function obtenerPisoID($piso,$hotel){
		$sql = $this->con->prepare("SELECT * FROM piso WHERE Piso_Numero = '".$piso."' AND Piso_Hotel = '".$hotel."'");
		$sql->execute();
		$res = $sql->fetchall();
		if (count($res) > 0)
		{
			foreach ($res as $dato)
			return $dato['Piso_ID'];
		}
		return -1;
	}

	function obtenerPiso($pisoID,$hotel){
		$sql = $this->con->prepare("SELECT * FROM piso WHERE Piso_ID = '".$pisoID."' AND Piso_Hotel = '".$hotel."'");
		$sql->execute();
		$res = $sql->fetchall();
		if (count($res) > 0)
		{
			foreach ($res as $dato)
			return $dato['Piso_Numero'];
		}
		return -2;
	}

	public function registrarHab($hab,$pisoID,$tipoHab){
		$sqltest = $this->con->prepare("SELECT * FROM habitacion  WHERE habitacion_piso = '".$pisoID."'  AND habitacion.Habitacion_Nombre = '".$hab."'");
		$sqltest->execute();
		$res = $sqltest->fetchall();
		if (count($res) < 1){
			$sql = $this->con->prepare( "INSERT INTO habitacion (habitacion_piso, habitacion_nombre, habitacion_tipo) 
	    	VALUES ('".$pisoID."','".$hab."','".$tipoHab."')" );
	    	$sql->execute();
    	}
		return "se ha realizado con exito la configuración";

	}
       
	function registrarTipoHab($hotel,$nombre,$precio,$numCamas,$limpNormal,$limpProf){

		$sqltest = $this->con->prepare("SELECT * FROM tipohabitacion  WHERE tipohab_hotel = '".$hotel."' AND tipohab_nombre = '".$nombre."'");
		$sqltest->execute();
		$res = $sqltest->fetchall();
		if (count($res) < 1){
			$sql = $this->con->prepare( "INSERT INTO tipohabitacion (TipoHab_hotel,TipoHab_nombre,
			 tipohab_precio,tipohab_numcamas,tipohab_TiempoLimpNormal, TipoHab_tiempolimpprofunda) 
	    	VALUES ('".$hotel."','".$nombre."','".$precio."','".$numCamas."','".$limpNormal."','".$limpProf."')" );
	    	$sql->execute();
			return "se haregistrado la habitación " . $nombre . " correctamente";
    	}
		else {
			return "la habitación ya estaba registrada";
		}
	}

	function modificarTipoHab($hotel,$ID,$nombre,$precio,$numCamas,$limpNormal,$limpProf){
		$sql = $this->con->prepare("UPDATE tipohabitacion SET tipohab_nombre = '".$nombre."',
		tipohab_precio = '".$precio."', tipohab_numcamas = '".$numCamas."',
		tipohab_tiempolimpnormal = '".$limpNormal."', tipohab_tiempolimpprofunda = '".$limpProf."'
		WHERE tipohab_ID = '".$ID."' AND tipohab_hotel = '".$hotel."' ");
		$sql->execute();
		return "se ha modificado la habitación " . $nombre. " correctamente";
	}

	function cambiarTipoHab($habID, $tipoID){
		$sql = $this->con->prepare("UPDATE habitacion SET Habitacion_Tipo = ".$tipoID."
		WHERE Habitacion_ID = ".$habID);
		$sql->execute();
		return "Se ha cambiado el tipo de habitacion";
	}
 
	function obtenerTiposHabs($hotel){
		$sql = $this->con->prepare("SELECT tipohab_ID, tipohab_nombre, tipohab_precio,
		tipohab_numCamas, tipohab_TiempoLimpNormal, tipohab_TiempoLimpProfunda FROM tipohabitacion WHERE
		tipohab_hotel = '".$hotel."'");
		$sql->execute();
		$res = $sql->fetchall();
		
		return $res;

	}

	function obtenerTipoHab($hotel,$ID){
		$sql = $this->con->prepare("SELECT * FROM tipohabitacion WHERE
		tipohab_hotel = '".$hotel."' AND tipohab_ID = '".$ID."'");
		$sql->execute();
		$res = $sql->fetchall();
		
		return $res;

	}

	function obtenerPisos($hotel){
		$sql = $this->con->prepare("SELECT piso_numero, piso_ID FROM piso WHERE Piso_Hotel = '".$hotel."' ORDER BY Piso_Numero ASC");
		$sql->execute();
		$res = $sql->fetchall();
		return $res;
	}

	function obtenerNumHabs($hotel, $piso){
		$sql = $this->con->prepare("SELECT habitacion_nombre FROM habitacion WHERE habitacion_piso =  $piso");
		$sql->execute();
		$res = $sql->fetchall();
		return count($res);
	}

	function obtenerHabs($hotel, $piso){
		$sql = $this->con->prepare("SELECT habitacion_ID, habitacion_nombre, habitacion_tipo, habitacion_estado,
		tipohabitacion.TipoHab_Nombre, tipohabitacion.TipoHab_Precio, tipohabitacion.TipoHab_NumCamas,
		tipohabitacion.TipoHab_TiempoLimpNormal, tipohabitacion.TipoHab_TiempoLimpProfunda
		 FROM habitacion INNER JOIN tipohabitacion ON habitacion.Habitacion_Tipo = tipohabitacion.TipoHab_ID WHERE habitacion_piso =  '".$piso."' ORDER BY habitacion.Habitacion_Nombre ASC");
		$sql->execute();
		$res = $sql->fetchall();
		return $res;
	}
	
	function eliminarHab($hab){  //Añadir condicinal al hotel
		$sql = $this->con->prepare("DELETE FROM habitacion WHERE habitacion_nombre =  $hab");
		$sql->execute();
		
		return;
	}

	function eliminarPiso($pisoID){
		$sql = $this->con->prepare("DELETE FROM piso WHERE piso_ID =  $pisoID");
		$sql->execute();
		
		return "se eliminó el piso correctamente" . $pisoID;
	}

	function eliminarHabsDePiso($pisoID){
		$sql = $this->con->prepare("DELETE FROM habitacion WHERE habitacion_piso =  $pisoID");
		$sql->execute();
		
		return;
	}

}

?>