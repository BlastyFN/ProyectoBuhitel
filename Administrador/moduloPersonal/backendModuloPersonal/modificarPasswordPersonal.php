<?php
session_start();
    include "bd.php";
    if(isset($_POST['password']) &&  isset($_POST['confirmPassword'])){

        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $NuevaClave = md5($password);
        $personalId =  $_POST['personalID'];
	    $bd = new database();

        if($password == $confirmPassword){
            $res = $bd-> modificarPasswordPersonal($personalId,$NuevaClave);
        } else {
            $res = "Las contraseñas no coinciden";
        }
        
        echo $res;
        
    }

?>