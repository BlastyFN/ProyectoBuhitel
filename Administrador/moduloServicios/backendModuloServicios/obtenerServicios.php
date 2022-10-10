<?php
    include "bd.php";
    session_start();
    $hotel =  $_SESSION['sesionPersonal']['Hotel'];
    $COrden = $_POST['Orden'];
    $bd = new database();
    $res = $bd-> obtenerServicios($hotel, $COrden);
    echo json_encode($res);


?>