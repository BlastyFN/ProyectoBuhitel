<?php
class database
{
	
	private $con;

	function __construct(){
		$this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022');	
    }

	function obtenerReportes($personal){
		$sql = $this->con->prepare("SELECT reporte.Reporte_ID, reporte.Reporte_Nombre, 
        categoriareporte.CatReporte_Nombre FROM reporte INNER JOIN categoriareporte ON reporte.Reporte_Categoria 
        = categoriareporte.CatReporte_ID WHERE reporte.Reporte_Usuario = '".$personal."'");
		$sql->execute();
		$res = $sql->fetchall();
		
		return $res;
	}

    function obtenerReporteEspecifico($reporte_id){
		$sql = $this->con->prepare("SELECT reporte.Reporte_ID, reporte.Reporte_Nombre, 
        categoriareporte.CatReporte_Nombre, reporte.Reporte_Contenido, reporte.Reporte_usuario, 
		reporte.Reporte_Servicio, reporte.Reporte_Estatus FROM reporte INNER JOIN categoriareporte ON reporte.Reporte_Categoria 
        = categoriareporte.CatReporte_ID WHERE reporte.Reporte_ID = '".$reporte_id."'");
		$sql->execute();
		$res = $sql->fetchall();
		
		return $res;
	}

	



}

?>