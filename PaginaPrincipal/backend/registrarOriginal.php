<?php
session_start();
include "bdPrincipal.php";

if(isset($_POST['Nombre']) && isset($_POST['PApellido']) && isset($_POST['SApellido']) && isset($_POST['Correo']) && isset($_POST['Telefono']) && isset($_POST['Hotel']) && isset($_POST['Contrasena']) && isset($_POST['Codigo'])){
    $Codigo = $_POST['Codigo'];
    if ( $_SESSION['sesionConfirmar'] == $Codigo) {
        //ASOCIACIÓN DE VARIABLES
        $HotelNombre = $_POST['Hotel'];
        $Correo = $_POST['Correo'];
        $PersonalNombre = $_POST['Nombre'];
        $PersonalAPaterno = $_POST['PApellido'];
        $PersonalAMaterno = $_POST['SApellido'];
        $PersonalTelefono = $_POST['Telefono'];
        $PersonalClave = $_POST['Contrasena'];
        //CREACIÓN DE OBJETO DB
        $bd = new database();
        //LLAMADA A LA FUNCIÓN
        $res = $bd->registroPrincipal($HotelNombre, $Correo, $PersonalNombre, $PersonalAPaterno, $PersonalAMaterno, $PersonalTelefono, $PersonalClave);
        echo '1';
    }else {
        echo '0';
    }
	
}
?>