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

	function obtenerPersonalTrabajando($hotel, $fecha){
		$sql = $this->con->prepare("SELECT * FROM infousuariolimpieza 
		INNER JOIN personal ON personal.Personal_ID = InfoLimpieza_Personal
		WHERE BINARY '".$fecha."' BETWEEN InfoLimpieza_InicioJornada AND InfoLimpieza_FinJornada
		AND BINARY personal.Personal_Hotel = '".$hotel."'");
		$sql->execute();
		$res = $sql->fetchall();
		return count($res);
	}

	function obtenerProductoPedidos($hotel){
		$sql = $this->con->prepare("SELECT Producto_ID, Producto_Nombre FROM producto 
		INNER JOIN categoriaproductos ON categoriaproductos.CatProd_ID = Producto_Categoria
		WHERE BINARY categoriaproductos.CatProd_Hotel = '".$hotel."'");
		$sql->execute();
		$productos = $sql->fetchall();
		$Lista = array();
		foreach ($productos as $key => $producto) {
			$sql = $this->con->prepare("SELECT CarroProd_NumProductos FROM carritoproductos
			WHERE BINARY CarroProd_Producto = '".$producto['Producto_ID']."'");
			$sql->execute();
			$consulta = $sql->fetchall();
			if (count($consulta)>0) {
				$cantidad = 0;
				foreach ($consulta as $key => $pedido) {
					$cantidad = $cantidad +  $pedido['CarroProd_NumProductos'];
				}
				$elemento['Nombre'] = $producto['Producto_Nombre'];
				$elemento['ID'] = $producto['Producto_ID'];
				$elemento['Cantidad'] = $cantidad;
				array_push($Lista, $elemento);
			}
			
		}
		return $Lista;
	}

	function obtenerCategoriasReportadas($hotel){
		$sql = $this->con->prepare("SELECT CatReporte_ID, CatReporte_Nombre FROM categoriareporte
		WHERE BINARY CatReporte_Hotel = '".$hotel."'");
		$sql->execute();
		$categorias = $sql->fetchall();
		$Lista = array();
		foreach ($categorias as $key => $categoria) {
			$sql = $this->con->prepare("SELECT Reporte_ID FROM reporte 
			WHERE BINARY Reporte_Categoria = '".$categoria['CatReporte_ID']."'");
			$sql->execute();
			$consulta = $sql->fetchall();
			$cantidad = count($consulta);
			$elemento['Nombre'] = $categoria['CatReporte_Nombre'];
			$elemento['ID'] = $categoria['CatReporte_ID'];
			$elemento['Cantidad'] = $cantidad;
			array_push($Lista, $elemento);
			
		}
		return $Lista;
	}

	function obtenerTiposHabReservadas($hotel){
		$sql = $this->con->prepare("SELECT TipoHab_ID, TipoHab_Nombre FROM tipohabitacion
		WHERE BINARY TipoHab_Hotel = '".$hotel."'");
		$sql->execute();
		$tipos = $sql->fetchall();
		$Lista = array();
		foreach ($tipos as $key => $tipo) {
			$sql = $this->con->prepare("SELECT tipohabitacion.TipoHab_Nombre, habitacion.Habitacion_Nombre FROM habitacionreservada
			INNER JOIN habitacion ON habitacion.Habitacion_ID = HabReservada_Habitacion
			INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo
			WHERE BINARY tipohabitacion.TipoHab_ID = '".$tipo['TipoHab_ID']."'");
			$sql->execute();
			$consulta = $sql->fetchall();
			$cantidad = count($consulta);
			$elemento['Nombre'] = $tipo['TipoHab_Nombre'];
			$elemento['ID'] = $tipo['TipoHab_ID'];
			$elemento['Cantidad'] = $cantidad;
			array_push($Lista, $elemento);
			
		}
		return $Lista;
	}


}

?>