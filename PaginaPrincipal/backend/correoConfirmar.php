<?php
session_start();
include "Correos.php";

if(isset($_POST['Correo'])){
	//ASOCIACIÓN DE VARIABLES
	$Correo = $_POST['Correo'];
    $Titulo = 'Codigo de confirmacion';
    $Mensaje = 'Hola! Aquí está tu código para completar el registro de tu cuenta: ';

    $codigo = '';
    $caracteres = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
    $numCar = strlen($caracteres);
    for ($i=0; $i < 6; $i++) { 
        $caracterRandom = $caracteres[mt_rand(0, $numCar-1)];
        $codigo .= $caracterRandom;
    }
    $Mensaje .= $codigo;
    //CREACIÓN DE OBJETO DB
	$cor = new mailer();
    //LLAMADA A LA FUNCIÓN
	$res = $cor->enviarCorreo($Correo, $Titulo, $Mensaje);

    $_SESSION['sesionConfirmar'] = $codigo;

    echo $res;
}
?>