<?php
class database
{
	
	private $con;

	function __construct(){
		$this->con = new PDO ('mysql:host localhost= localhost;dbname=corpo206_buhitel','root','');
	}


	function obtenerReportes($hotel){
		$sql = $this->con->prepare("SELECT reporte.Reporte_ID, reporte.Reporte_Nombre, 
        categoriareporte.CatReporte_Nombre FROM reporte INNER JOIN categoriareporte ON reporte.Reporte_Categoria 
        = categoriareporte.CatReporte_ID WHERE categoriareporte.CatReporte_Hotel = '".$hotel."'");
		$sql->execute();
		$res = $sql->fetchall();
		
		return $res;
	}

    function obtenerReporteEspecifico($reporte_id){
		$sql = $this->con->prepare("SELECT reporte.Reporte_Nombre, 
        categoriareporte.CatReporte_Nombre, reporte.Reporte_Contenido FROM reporte INNER JOIN categoriareporte ON reporte.Reporte_Categoria 
        = categoriareporte.CatReporte_ID WHERE reporte.Reporte_ID = '".$reporte_id."'");
		$sql->execute();
		$res = $sql->fetchall();
		
		return $res;
	}

    






}

?>