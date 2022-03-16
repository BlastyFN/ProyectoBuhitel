<?php
session_start();
include "bdPrincipal.php";

if(isset($_POST['Correo']) && isset($_POST['Clave'])){
	//ASOCIACIÓN DE VARIABLES
	$Correo = $_POST['Correo'];
    $Clave = $_POST['Clave'];
    //CREACIÓN DE OBJETO DB
	$bd = new database();
    //LLAMADA A LA FUNCIÓN PARA VER SI EXISTE CORREO
	$res = $bd->consultarCorreo($Correo);
    if ($res==true) {
        //CORREO DETECTADO
        //LLAMAR A FUNCIÓN DE CONSULTAR SESIÓN, MANDAR CORREO Y CONTRASEÑA PARA QUE RETORNE UN VALOR 
        $ClaveEncriptada = md5($Clave);
        $res2 = $bd->consultarSesion($Correo, $ClaveEncriptada);
        //SI NO ES FALSO ES QUE RETORNO ALGO
        if ($res2!=false) {
            //CUENTA VERIFICADA
            $datos = json_encode($res2[0]);
            echo($datos);
            //INICIA LA SESION
            $_SESSION['sesionPersonal'] = array();
            $_SESSION['sesionPersonal']['ID'] = $res2[0]['Personal_ID'];
            $_SESSION['sesionPersonal']['Hotel'] = $res2[0]['Personal_Hotel'];
            $_SESSION['sesionPersonal']['Tipo'] = $res2[0]['Personal_Tipo'];
            $_SESSION['sesionPersonal']['Nombre'] = $res2[0]['Personal_Nombre'];
        }
        else{
            //CONTRASEÑA INCORRECTA
            echo 1;
            session_destroy();
        }
    }
    else {
        //CORREO NO DETECTADO
        echo(0);
        session_destroy();
    }
}
?>