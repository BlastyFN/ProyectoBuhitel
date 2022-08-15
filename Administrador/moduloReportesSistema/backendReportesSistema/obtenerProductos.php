<?php
session_start();
    include "bd.php";
 
    $bd = new database();
    $hotel = 46;
    
    $arregloRes = $bd->obtenerProductos($hotel); 
        
       

    echo json_encode($arregloRes);
    


?>