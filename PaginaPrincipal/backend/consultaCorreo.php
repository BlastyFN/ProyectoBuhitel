<?php
include "bdPrincipal.php";

if(isset($_POST['Correo'])){
	//ASOCIACIÓN DE VARIABLES
	$Correo = $_POST['Correo'];
    //CREACIÓN DE OBJETO DB
	$bd = new database();
    //LLAMADA A LA FUNCIÓN
	$res = $bd->consultarCorreo($Correo);
    if ($res==true) {
        echo(1);
    }
    else {
        echo(0);
    }
}
?>