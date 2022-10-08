<?php
class database
{
	
	private $con;

	function __construct(){
		$this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022');
	}

	function registrarPersonal($hotel,$nombre,$apellidoP,$apellidoM,$tipoPersonal,$correo,$password,$seguroSocial){
		$sqltest = $this->con->prepare("SELECT * FROM personal  WHERE personal_hotel = '".$hotel."'  AND personal_correo = '".$correo."'");
		$sqltest->execute();
		$res = $sqltest->fetchall();
		if (count($res) < 1){
			$sql = $this->con->prepare( "INSERT INTO personal (personal_hotel, personal_nombre, personal_apaterno, 
			personal_amaterno, personal_tipo, personal_correo, personal_contrasena, personal_seguro) 
	    	VALUES ('".$hotel."','".$nombre."','".$apellidoP."','".$apellidoM."','".$tipoPersonal."','".$correo."',
			'".$password."','".$seguroSocial."')" );
	    	$sql->execute();

			$sql2 = $this->con->prepare("SELECT * FROM personal  WHERE personal_hotel = '".$hotel."'  AND personal_correo = '".$correo."'");
			$sql2->execute();
			$res2 = $sql2->fetchall();
		
			foreach ($res2 as $dato){
				return $dato['Personal_ID'];
			}
			
		
			
    	}
		else{
			return "no";
		}
	}

	function registrarInfousuarioLimpieza($personalID,$inicioJornada,$finJornada,$inicioDescanso,$finDescanso){
		$sqltest = $this->con->prepare("SELECT * FROM infousuariolimpieza  WHERE InfoLimpieza_ID = '".$personalID."'");
		$sqltest->execute();
		$res = $sqltest->fetchall();
		if (count($res) < 1){
			$sql = $this->con->prepare( "INSERT INTO infousuariolimpieza (InfoLimpieza_Personal, 
			InfoLimpieza_InicioJornada, InfoLimpieza_FinJornada, InfoLimpieza_InicioDescanso, 
			InfoLimpieza_FinDescanso) 
	    	VALUES ('".$personalID."','".$inicioJornada."','".$finJornada."','".$inicioDescanso."',
			'".$finDescanso."')");
	    	$sql->execute();
			return "se ha registrado correctamente la información del usuario de limpieza";
    	}
		else{
			return "no";
		}
	}


	function obtenerPersonal($hotel){
		$sql = $this->con->prepare("SELECT personal_id, personal_nombre, personal_apaterno, personal_amaterno, personal_tipo FROM personal WHERE
		personal_hotel = '".$hotel."'");
		$sql->execute();
		$res = $sql->fetchall();
		
		return $res;
	}

	function obtenerPersonalEspecifico($hotel,$personal_id){
		$sql = $this->con->prepare("SELECT * FROM personal WHERE
		personal_hotel = '".$hotel."' AND personal_ID =  '".$personal_id."'");
		$sql->execute();
		$res = $sql->fetchall();
		
		return $res;
	}	
	
	function obtenerHorarioPersonal($personal_id){
		$sql = $this->con->prepare("SELECT * FROM personal 
		INNER JOIN infousuariolimpieza ON infousuariolimpieza.InfoLimpieza_Personal = personal.Personal_ID
		WHERE personal_ID =  '".$personal_id."'");
		$sql->execute();
		$res = $sql->fetchall();
		
		return $res;
	}

	function eliminarPersonal($hotel,$personal_id){
		$sql = $this->con->prepare("DELETE FROM personal WHERE
		personal_hotel = '".$hotel."' AND personal_ID =  '".$personal_id."'");
		$sql->execute();
		$sql->fetchall();
		
		return "Eliminado";
	}

	function modificarPersonal($personalId,$nombre,$apellidoP,$apellidoM,$tipoPersonal,
	$correo,$password,$seguroSocial){

		$sql = $this->con->prepare( "UPDATE personal SET personal_nombre = '".$nombre."',
		personal_apaterno = '".$apellidoP."', personal_amaterno = '".$apellidoM."',
		personal_tipo = '".$tipoPersonal."', personal_correo = '".$correo."',personal_contrasena
		= '".$password."', personal_seguro = '".$seguroSocial."'
		WHERE personal_id = '".$personalId."'" );
	    $sql->execute();
		return "se ha realizado la modificación";

	}

	function modificarPasswordPersonal($personalId,$password){

		$sql = $this->con->prepare( "UPDATE personal 
		SET personal_contrasena = '".$password."'
		WHERE personal_id = '".$personalId."'");
	    $sql->execute();
		return "se ha cambiado la contraseña";

	}

	function modificarHorariosPersonal($personalId,$inicioJornada,
	$finJornada,$inicioDescanso,$finDescanso){

		$sql = $this->con->prepare( "UPDATE infousuariolimpieza
		INNER JOIN personal ON infolimpieza_personal = personal.personal_id
		SET infolimpieza_iniciojornada = '".$inicioJornada."',
		infolimpieza_finjornada = '".$finJornada."',
		InfoLimpieza_InicioDescanso = '".$inicioDescanso."',
		InfoLimpieza_FinDescanso = '".$finDescanso."'
		WHERE personal_id = '".$personalId."'");
	    $sql->execute();
		return "se ha cambiado el horario";

	}

}

?>