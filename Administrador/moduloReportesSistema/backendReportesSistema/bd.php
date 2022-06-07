<?php
class database
{
	
	private $con;

	function __construct(){
		$this->con = new PDO ('mysql:host localhost= localhost;dbname=corpo206_buhitel','root','');
	}

	function obtenerInfoGeneralServicio($fechaInicio,$fechaFin){
        $sql = $this->con->prepare("SELECT Servicio_PrecioTotal FROM servicio WHERE BINARY
        (Servicio_Fecha BETWEEN '".$fechaInicio."' AND '".$fechaFin."') ");
        $sql->execute();
        $res = $sql->fetchall();
        $resSuma = 0;
        foreach($res as $dato){
            $resSuma += $dato['Servicio_PrecioTotal'];      
        }
        return  $resSuma;
    
        
    }

}

?>