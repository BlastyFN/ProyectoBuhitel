<?php
    include "bd.php";
    session_start();
    $hotel = $_SESSION['sesionPersonal']['Hotel'];
    $nombreCat = $_POST["nombre"];
    $idReporte = $_POST["nombre"];

    $bd = new database();
    $idCategoria = $bd->obtenerCategoriaID($hotel,$nombreCat);
    $bd->marcarComoSpam($idCategoria);

?>