<?php
session_start();

if(isset($_POST['Codigo']) && isset($_SESSION['sesionRecuperar'])){
	//ASOCIACIÓN DE VARIABLES
	$Codigo = $_POST['Codigo'];
    if ($_SESSION['sesionRecuperar']['Codigo'] == $Codigo){
        echo 1;
    }
    else {
        echo "Codigo Incorrecto";
    }
    

}
else {
    echo "Información incompleta";
}
?>