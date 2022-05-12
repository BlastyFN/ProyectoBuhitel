<?php
    include "bd.php";
    session_start();
    if(isset($_POST['nombre']) &&  isset($_POST['precio']) && isset($_POST['numCamas']) 
    && isset($_POST['limpNormal']) && isset($_POST['limpProf'])){
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $numCamas = $_POST['numCamas'];
        $limpNormal = $_POST['limpNormal'];
        $limpProf = $_POST['limpProf'];
        
        $hotel =  $_SESSION['sesionPersonal']['Hotel'];
	    $bd = new database();
        $res = $bd-> registrarTipoHab($hotel, $nombre,$precio,$numCamas,$limpNormal,$limpProf);
        echo $res;
    }

?>