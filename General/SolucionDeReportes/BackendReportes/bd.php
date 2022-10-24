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
        = categoriareporte.CatReporte_ID WHERE reporte.Reporte_Usuario = '".$personal."'
		AND reporte.reporte_estatus != '5'
		AND reporte.reporte_estatus != '6'");
		$sql->execute();
		$res = $sql->fetchall();
		return $res;
	}

	function obtenerReportesNoLeidos($personal){
		$sql = $this->con->prepare("SELECT reporte.Reporte_ID, reporte.Reporte_Inicio, reporte.Reporte_Nombre, 
        categoriareporte.CatReporte_Nombre FROM reporte INNER JOIN categoriareporte ON reporte.Reporte_Categoria 
        = categoriareporte.CatReporte_ID 
		WHERE BINARY reporte.Reporte_Usuario = '".$personal."'
		AND BINARY Reporte_Estatus = '2'");
		$sql->execute();
		$res = $sql->fetchall();
		return $res;
	}

	public function obtenerNumero($Reporte){
		$sql = $this->con->prepare("SELECT habitacionreservada.HabReservada_NumWhatsapp FROM reporte
		INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_ID = Reporte_HabReservadas
		WHERE BINARY Reporte_ID = '".$Reporte."'");
		$sql->execute();
		$res = $sql->fetchall();
		$num = false;
		if ($res[0]['HabReservada_NumWhatsapp'] != '0') {
			$num = $res[0]['HabReservada_NumWhatsapp'];
		}
		else{
			$num = false;
		}
		return $num;
	}
    function obtenerReporteEspecifico($reporte_id){
		$sql = $this->con->prepare("SELECT reporte.Reporte_ID, reporte.Reporte_Nombre, 
        categoriareporte.CatReporte_Nombre, reporte.Reporte_Contenido, reporte.Reporte_usuario, 
		reporte.Reporte_Servicio, estatusreporte.EstatusReporte_Estatus FROM reporte 
		INNER JOIN categoriareporte ON reporte.Reporte_Categoria = categoriareporte.CatReporte_ID 
		INNER JOIN estatusreporte ON reporte.Reporte_Estatus = estatusreporte.EstatusReporte_ID
		WHERE reporte.Reporte_ID = '".$reporte_id."'");
		$sql->execute();
		$res = $sql->fetchall();
		
		return $res;
	}

	function completarReporte($reporte_id,$hoy){
		$sql = $this->con->prepare("UPDATE reporte 
		SET Reporte_Estatus = '5', Reporte_Final = '".$hoy."' 
		WHERE Reporte_ID = '".$reporte_id."'");
		$sql->execute();
		$res = $sql->fetchall();
		
		return "0";
	}

	function marcarReporteVisto($reporte_id){
		$sql = $this->con->prepare("UPDATE reporte 
		SET Reporte_Estatus = '3' 
		WHERE Reporte_ID = '".$reporte_id."'");
		$sql->execute();
		$res = $sql->fetchall();
		
		return "0";
	}

	function iniciarReporte($reporte_id){
		$sql = $this->con->prepare("UPDATE reporte 
		SET Reporte_Estatus = '4' 
		WHERE Reporte_ID = '".$reporte_id."'");
		$sql->execute();
		$res = $sql->fetchall();
		
		return "0";
	}



}

?>