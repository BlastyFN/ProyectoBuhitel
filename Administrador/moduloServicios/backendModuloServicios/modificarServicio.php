<?php
    include "bd.php";
    if(isset($_POST['nombre']) &&  isset($_POST['categoria']) && isset($_POST['precio']) 
    && isset($_POST['descripcion'])){

        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
       
        
        $hotel = 1;
        $personalId = $_POST['productoID'];
	    $bd = new database();
        //$res = $bd-> modificarPersonal($hotel,$personalId,$nombre,$apellidoP,$apellidoM,$tipoPersonal,$correo,$password,$seguroSocial);
        echo "si";
    }

?>