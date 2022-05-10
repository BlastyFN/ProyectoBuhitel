<?php 
    session_start();
    include "bdservicios.php";
    if (isset($_SESSION['sesionPersonal']['Hotel'])){
        $bd = new database();
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $res = $bd->consultarCategorias($Hotel);
        if (isset($res[0])) {
            $datos = json_encode($res);
            echo $datos;
        }
        else {
            echo 0;
        }
    }

?>