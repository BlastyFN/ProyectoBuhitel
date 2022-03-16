<?php
session_start();
include "bdPrincipal.php";
if (isset($_POST['Clave']) && isset($_SESSION['sesionRecuperar'])){
    $Correo = $_SESSION['sesionRecuperar']['Correo'];
    $Clave = $_POST['Clave'];
    $ClaveEncriptada = md5($Clave);
    $bd = new database();
    //LLAMADA A LA FUNCIÓN
    $res = $bd->renovarClave($Correo, $ClaveEncriptada);
    echo $res;
}

session_destroy();
?>