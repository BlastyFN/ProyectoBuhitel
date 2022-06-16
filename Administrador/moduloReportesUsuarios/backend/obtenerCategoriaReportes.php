<?php
    include "bd.php";
    session_start();
   

        //$hotel = $_SESSION['sesionPersonal']['Hotel'];
        $hotel = 46;
       
        $bd = new database();
        $res = $bd-> obtenerCategoriaReportes($hotel);
        echo json_encode($res);

    
?>