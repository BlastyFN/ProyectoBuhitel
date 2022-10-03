<?php
    include "bd.php";
    if(isset($_POST['nombre']) &&  isset($_POST['categoria']) && isset($_POST['precio']) 
    && isset($_POST['descripcion'])){

        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
       
        $productoId = $_POST['productoID'];
	    $bd = new database();
        $res = $bd-> modificarServicio($productoId,$nombre,$categoria,$precio,$descripcion);
        return $res;
    }

?>