<?php 
    session_start();
    include "bdservicios.php";
    if (isset($_SESSION['sesionPersonal']['Hotel']) && isset($_POST['Servicio']) && isset($_POST['Producto']) && isset($_POST['Cantidad'])){
        $bd = new database();
        $Servicio = $_POST['Servicio'];
        $Producto = $_POST['Producto'];
        $Cantidad = $_POST['Cantidad'];
        $res = $bd->registrarCarrito($Servicio, $Producto, $Cantidad);
        echo $res;
    }

?>