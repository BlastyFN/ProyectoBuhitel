<?php
class database
{
	
	private $con;

	function __construct(){
		$this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','root','');
	}

	function crearCategoria($categoria){
		$sql = $this->con->prepare( "SELECT * FROM categoriaproductos (catprod_categoria) 
	    VALUES ('".$categoria."')" );
	    $sql->execute();
		return "se ha realizado con exito la configuración";
    	
	}

	
}

?>