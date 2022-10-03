<?php
    include "bd.php";
    session_start();
    if(isset($_POST['productoID'])){
        $hotel =  $_SESSION['sesionPersonal']['Hotel'];
        $producto_id = $_POST['productoID'];
        $bd = new database();
        $res = $bd-> obtenerServicioEspecifico($hotel,$producto_id);
        return $res;

    }
?>