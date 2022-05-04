<?php
    include "bd.php";
    if(isset($_POST['tipohab_ID'])){
        $ID = $_POST['tipohab_ID'];
  
        
        $hotel = 1;
	    $bd = new database();
        $res = $bd-> obtenerTipoHab($hotel,$ID);
        echo json_encode($res); 
    }

?>