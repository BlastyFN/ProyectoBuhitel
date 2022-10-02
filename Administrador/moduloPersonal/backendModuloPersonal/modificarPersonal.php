<?php
session_start();
    include "bd.php";
    if(isset($_POST['nombres']) &&  isset($_POST['apellidoP']) && isset($_POST['apellidoM']) 
    && isset($_POST['tipoPersonal']) && isset($_POST['correo'])
    && isset($_POST['seguroSocial'])){

        $nombre = $_POST['nombres'];
        $apellidoP = $_POST['apellidoP'];
        $apellidoM = $_POST['apellidoM'];
        $tipoPersonal = $_POST['tipoPersonal'];
        $correo = $_POST['correo'];
        $password = $_POST['password'];
        $passwordS = md5($password);
        $seguroSocial = $_POST['seguroSocial'];
        
        $personalId =  $_POST['personalID'];
	    $bd = new database();
        $res = $bd-> modificarPersonal($personalId,$nombre,$apellidoP,$apellidoM,$tipoPersonal,$correo,$passwordS,$seguroSocial);
        echo $res;
    }

?>