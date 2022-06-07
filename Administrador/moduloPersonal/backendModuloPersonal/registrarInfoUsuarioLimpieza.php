<?php
    include "bd.php";
    session_start();
    if(isset($_POST['inicioJornada']) &&  isset($_POST['finJornada']) && isset($_POST['inicioDescanso']) 
    && isset($_POST['finDescanso'])){

        $personalID =  $_SESSION['sesionPersonal']['Hotel'];
        $inicioJornada = $_POST['inicioJornada'];
        $finJornada = $_POST['finJornada'];
        $inicioDescanso = $_POST['inicioDescanso'];
        $finDescanso = $_POST['finDescanso'];

        
        //$hotel =  $_SESSION['sesionPersonal']['Hotel'];
	    $bd = new database();
        $res = $bd-> registrarInfoUsuarioLimpieza($personalID,$inicioJornada,$finJornada,$inicioDescanso,$finDescanso);
        echo $res;
        echo "si";
    }

?>