<?php
session_start();
include "Correos.php";

if(isset($_POST['Correo'])){
	//ASOCIACIÓN DE VARIABLES
	$Correo = $_POST['Correo'];
    $Titulo = 'Codigo de recuperacion';
    $Mensaje = 'Hola! Aquí está tu código para recuperar tu contraseña: ';

    $codigo = '';
    $caracteres = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
    $numCar = strlen($caracteres);
    for ($i=0; $i < 6; $i++) { 
        $caracterRandom = $caracteres[mt_rand(0, $numCar-1)];
        $codigo .= $caracterRandom;
    }
    $Mensaje .= $codigo;
    $Mensaje .= " Si NO solicitaste recuperar tu contraseña, haz caso omiso a este correo";
    //CREACIÓN DE OBJETO DB
	$cor = new mailer();
    //LLAMADA A LA FUNCIÓN
	$res = $cor->enviarCorreo($Correo, $Titulo, $Mensaje);
    $_SESSION['sesionRecuperar'] = array();
    $_SESSION['sesionRecuperar']['Codigo'] = $codigo;
    $_SESSION['sesionRecuperar']['Correo'] = $Correo;


    echo $res;
}
?>