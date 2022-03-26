<?php 
    session_start();
    include "bdReservacion.php";
    if (isset($_POST['Nombre']) && isset($_POST['Apellidos']) && isset($_POST['Contacto']) && isset($_POST['CIN']) && isset($_POST['COUT'])) {
        $Nombre = $_POST['Nombre'];
        $Apellidos = $_POST['Apellidos'];
        $Contacto = $_POST['Contacto'];
        $CIN = $_POST['CIN'];
        $COUT = $_POST['COUT'];
        $bd = new database();
        $regH = $bd->registrarReservacion($Nombre, $Apellidos, $Contacto, $CIN, $COUT);
        echo $regH;
    }

?>