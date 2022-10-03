<?php
    include "bd.php";
    session_start();
    if(isset($_POST['productoID'])){

        $hotel = $_SESSION['sesionPersonal']['Hotel'];
        $productoId = $_POST['productoID'];
        $bd = new database();
        $res = $bd-> eliminarProducto($productoId);
        echo json_encode($res);

    }
?>