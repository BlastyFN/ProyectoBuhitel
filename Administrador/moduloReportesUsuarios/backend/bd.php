<?php
class database
{
	
	private $con;

	function __construct(){
		$this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022');	
	}

	function obtenerListaPersonal($hotel, $tipo){
		$sql = $this->con->prepare("SELECT * FROM personal 
		WHERE Personal_Tipo = '".$tipo."' AND Personal_Hotel = '".$hotel."'");
		$sql->execute();
		$res = $sql->fetchall();
			
		return $res;
	}

	function obtenerReportes($hotel){
		$sql = $this->con->prepare("SELECT reporte.Reporte_ID, reporte.Reporte_Nombre, 
        categoriareporte.CatReporte_Nombre FROM reporte INNER JOIN categoriareporte ON reporte.Reporte_Categoria 
        = categoriareporte.CatReporte_ID WHERE categoriareporte.CatReporte_Hotel = '".$hotel."' ORDER BY categoriareporte.CatReporte_Prioridad ASC
");
		$sql->execute();
		$res = $sql->fetchall();
		
		return $res;
	}

    function obtenerReporteEspecifico($reporte_id){
		$sql = $this->con->prepare("SELECT reporte.Reporte_ID, reporte.Reporte_Nombre, 
        categoriareporte.CatReporte_Nombre, reporte.Reporte_Contenido, reporte.Reporte_usuario, 
		reporte.Reporte_Servicio, reporte.Reporte_Estatus, estatusreporte.EstatusReporte_Estatus FROM reporte 
		INNER JOIN categoriareporte ON reporte.Reporte_Categoria = categoriareporte.CatReporte_ID
		INNER JOIN estatusreporte ON reporte.Reporte_Estatus = estatusreporte.EstatusReporte_ID
		WHERE reporte.Reporte_ID = '".$reporte_id."'");
		$sql->execute();
		$res = $sql->fetchall();
		
		return $res;
	}

	function obtenerCategoriaID($hotel, $nombreCat){
		$sql = $this->con->prepare("SELECT CatReporte_ID FROM categoriareporte 
		WHERE CatReporte_Hotel = '".$hotel."' &&
		CatReporte_Nombre = '".$nombreCat."'");
		$sql->execute();
		$res = $sql->fetchall();
		foreach ($res as $dato){
			return $dato['CatReporte_ID'];
		}
		
		return "0";	
	}

	function marcarComoSpam($categoria_id, $reporte_id){
		$sql = $this->con->prepare("UPDATE reporte 
		SET Reporte_Categoria = '".$categoria_id."' 
		WHERE Reporte_ID = '".$reporte_id."'");
		$sql->execute();
		$res = $sql->fetchall();
		
		return "0";
	}

	function completarReporte($reporte_id){
		$sql = $this->con->prepare("UPDATE reporte 
		SET Reporte_Estatus = '5' 
		WHERE Reporte_ID = '".$reporte_id."'");
		$sql->execute();
		$res = $sql->fetchall();
		
		return "0";
	}

	
    function obtenerCategoriaReportes($hotel){
		$sql = $this->con->prepare("SELECT * FROM categoriareporte  WHERE CatReporte_Hotel = '".$hotel."' ORDER BY CatReporte_Prioridad ASC");
		$sql->execute();
		$res = $sql->fetchall();
		
		return $res;
	}

	function reasignarCategoria($hotel,$nuevaPrioridad,$nombreCategoria){
		$sqltest = $this->con->prepare("SELECT * FROM categoriareporte WHERE CatReporte_Nombre = '".$nombreCategoria."' AND CatReporte_Hotel = '".$hotel."'");
		$sqltest->execute();
		$res = $sqltest->fetchall();
	
		if (count($res) > 0){
			$sql = $this->con->prepare("UPDATE categoriareporte 
			SET CatReporte_Prioridad = '".$nuevaPrioridad."' 
			WHERE CatReporte_Nombre = '".$nombreCategoria."'");
			$sql->execute();
			return "si";
			
		}else{
			$sql = $this->con->prepare("INSERT INTO categoriareporte 
			(CatReporte_Hotel, CatReporte_Nombre, CatReporte_Prioridad) VALUES 
			('".$hotel."', '".$nombreCategoria."', '".$nuevaPrioridad."')");
			$sql->execute();
			return "no";
			
		}
	}

	function asignarSeguimiento($personal, $servicio, $reporteID, $hoy){
		$sql = $this->con->prepare("UPDATE reporte SET  Reporte_Usuario =  '".$personal."',
		Reporte_Servicio =  '".$servicio."', Reporte_Estatus = 2, Reporte_Inicio = '".$hoy."'
		where reporte_ID =  '".$reporteID."' ;");
			$sql->execute();
			return "0";
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
    






}

?>