<?php
class database
{
	
	private $con;

	function __construct(){
		$this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022');
	}

	function crearCategoria($hotel,$categoria){
		$sqltest = $this->con->prepare("SELECT * FROM categoriaproductos  WHERE catprod_categoria = '".$categoria."'");
		$sqltest->execute();
		$res = $sqltest->fetchall();
		if (count($res) < 1){
			$sql = $this->con->prepare( "INSERT INTO categoriaproductos (catprod_categoria, CatProd_Hotel) 
	    	VALUES ('".$categoria."','".$hotel."')" );
	    	$sql->execute();
			return "se ha realizado con exito la configuración";
    	}
		else{
			return "no";
		}
	}

	function obtenerCategoriaID($categoria){
		$sql = $this->con->prepare("SELECT * FROM categoriaproductos WHERE catprod_categoria = '".$categoria."'");
		$sql->execute();
		$res = $sql->fetchall();
		if (count($res) > 0)
		{
			foreach ($res as $dato)
			return $dato['CatProd_ID'];
		}
		return -1;
	}
	public function consultarCategorias($Hotel){
		$sql = $this->con->prepare("SELECT CatProd_ID, CatProd_Categoria FROM categoriaproductos
		WHERE BINARY CatProd_Hotel = '".$Hotel."' ");
		$sql->execute();
		$res = $sql->fetchall();
		return $res;
	}

	public function consultarProductos($Categoria){
		$sql = $this->con->prepare("SELECT Producto_ID, Producto_Nombre, Producto_Existencia FROM producto 
		WHERE BINARY Producto_Categoria ='".$Categoria."'");
		$sql->execute();
		$res = $sql->fetchall();
		return $res;
	}
	public function cambiarExistencia ($Producto, $Existencia){
		$sql = $this->con->prepare("UPDATE producto SET Producto_Existencia= '".$Existencia."' WHERE BINARY Producto_ID = '".$Producto."'");
		$sql->execute();
		return 1;
	}

	function registrarServicio($hotel,$nombre,$categoria,$precio,$descripcion){
		$sqltest = $this->con->prepare("SELECT * FROM producto  WHERE producto_hotel = '".$hotel."'  AND producto_nombre = '".$nombre."'");
		$sqltest->execute();
		$res = $sqltest->fetchall();
		if (count($res) < 1){
			$sql = $this->con->prepare( "INSERT INTO producto (producto_hotel, producto_nombre, producto_categoria, 
			producto_precio, producto_descripcion) 
	    	VALUES ('".$hotel."','".$nombre."','".$categoria."','".$precio."','".$descripcion."')");
	    	$sql->execute();
			return "se ha realizado con exito el registro";
    	}
		else{
			return "El producto ya está registrado";
		}
	}

	function obtenerServicios($hotel){
		$sql = $this->con->prepare("SELECT producto.producto_id, producto.producto_nombre, 
		categoriaproductos.catprod_categoria, producto_existencia FROM producto INNER JOIN categoriaproductos ON 
		producto.producto_categoria = categoriaproductos.CatProd_ID WHERE producto_hotel = '".$hotel."' ");
		$sql->execute();
		$res = $sql->fetchall();
		
		return $res;
	}

	function obtenerServicioEspecifico($hotel,$servicio_id){
		$sql = $this->con->prepare("SELECT * FROM producto INNER JOIN categoriaproductos ON 
		producto.producto_categoria = categoriaproductos.CatProd_ID  WHERE
		producto_hotel = '".$hotel."' AND producto_ID =  '".$servicio_id."'");
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