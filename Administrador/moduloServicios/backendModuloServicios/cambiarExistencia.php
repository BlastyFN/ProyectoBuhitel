<?php 
    session_start();
    include "bd.php";
    if (isset($_POST['Producto']) && isset($_POST['Existencia'])) {
        $Producto = $_POST['Producto'];
        $Existencia = $_POST['Existencia'];
        $bd = new database();
        $res = $bd->cambiarExistencia($Producto, $Existencia);
        echo $res;
        
    }
    else {
        echo "x";
    }
    
?>