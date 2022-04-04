<?php 
    session_start();
    include "bdReservacion.php";
    if (isset($_POST['Nombre']) && isset($_POST['Apellidos']) && isset($_POST['Contacto']) && isset($_POST['Huesped'])) {
        $Nombre = $_POST['Nombre'];
        $Apellidos = $_POST['Apellidos'];
        $Contacto = $_POST['Contacto'];
        $Huesped = $_POST['Huesped'];
        $bd = new database();
        $regH = $bd->actualizarHuesped($Nombre, $Apellidos, $Contacto, $Huesped);
        echo $regH;
    }

?>