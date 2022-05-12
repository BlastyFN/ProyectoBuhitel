<?php
    include "bd.php";
    session_start();
    if(isset($_POST['tipohab_ID'])){
        $ID = $_POST['tipohab_ID'];
  
        
        $hotel =  $_SESSION['sesionPersonal']['Hotel'];
	    $bd = new database();
        $res = $bd-> obtenerTipoHab($hotel,$ID);
        echo json_encode($res); 
    }

?>