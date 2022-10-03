<?php
    include "bd.php";
    if(isset($_POST['nombres']) &&  isset($_POST['apellidoP']) && isset($_POST['apellidoM']) 
    && isset($_POST['tipoPersonal']) && isset($_POST['correo']) && isset($_POST['password'])
    && isset($_POST['seguroSocial'])){

        $nombre = $_POST['nombres'];
        $apellidoP = $_POST['apellidoP'];
        $apellidoM = $_POST['apellidoM'];
        $tipoPersonal = $_POST['tipoPersonal'];
        $correo = $_POST['correo'];
        $password = $_POST['password'];
        $seguroSocial = $_POST['seguroSocial'];
        
        $hotel = 1;
        $personalId = 2;
	    $bd = new database();
        $res = $bd-> modificarPersonal($hotel,$personalId,$nombre,$apellidoP,$apellidoM,$tipoPersonal,$correo,$password,$seguroSocial);
        echo $res;
    }

?>