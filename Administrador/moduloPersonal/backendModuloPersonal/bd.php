<?php
class database
{
	
	private $con;

	function __construct(){
		$this->con = new PDO ('mysql:host = localhost;dbname=Buhitel','root','');
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
			return "se ha realizado con exito la configuración";
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

	function modificarPersonal($hotel,$personalId,$nombre,$apellidoP,$apellidoM,$tipoPersonal,
	$correo,$password,$seguroSocial){

		$sql = $this->con->prepare( "UPDATE personal SET personal_nombre = '".$nombre."',
		personal_apaterno = '".$apellidoP."', personal_amaterno = '".$apellidoM."',
		personal_tipo = '".$tipoPersonal."', personal_correo = '".$correo."',personal_contrasena
		= '".$password."', personal_seguro = '".$seguroSocial."'
		WHERE personal_id = '".$personalId."' AND personal_hotel = '".$hotel."' " );
	    $sql->execute();
		return "se ha realizado la modificación";

	}

}

?>