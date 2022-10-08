<?php
session_start();
    include "bd.php";
    if(isset($_POST['inicioJornada']) &&  isset($_POST['finJornada']) && 
    isset($_POST['inicioDescanso']) &&  isset($_POST['finDescanso'])){

        $inicioJornada = $_POST['inicioJornada'];
        $finJornada = $_POST['finJornada'];
        $inicioDescanso = $_POST['inicioDescanso'];
        $finDescanso = $_POST['finDescanso'];
        $NuevaClave = md5($password);
        $personalId =  $_POST['personalID'];
	    $bd = new database();

        $res = $bd-> modificarHorariosPersonal($personalId,$
        $inicioJornada,$finJornada,$inicioDescanso,$finDescanso);
        
        
        echo $res;
        
    }

?>