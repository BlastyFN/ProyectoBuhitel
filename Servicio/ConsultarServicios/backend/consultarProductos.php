<?php 
    session_start();
    include "bdservicios.php";
    if (isset($_POST['Categoria'])) {
        $Categoria = $_POST['Categoria'];
        $bd = new database();
        $res = $bd->consultarProductos($Categoria);
        if (isset($res[0])) {
            $info = json_encode($res);
            echo $info;        
        }
        else{
            echo 0;
        }
        
    }
    else {
        echo "x";
    }
    
?>