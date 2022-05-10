<?php 
    session_start();
    include "bdservicios.php";
    if (isset($_SESSION['sesionPersonal']['Hotel']) && isset($_POST['Categoria'])){
        $bd = new database();
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $Categoria = $_POST['Categoria'];
        $res = $bd->consultarProductos($Hotel, $Categoria);
        if (isset($res[0])) {
            $datos = json_encode($res);
            echo $datos;
        }
        else {
            echo 0;
        }
    }

?>