<?php 
    session_start();
    include "bdservicios.php";
    if (isset($_SESSION['sesionPersonal']['Hotel']) && isset($_POST['Limpieza'])){
        $bd = new database();
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $Limpieza = $_POST['Limpieza'];
        $res = $bd->cancelarLimpieza($Hotel, $Limpieza);
        echo $res;
    }

?>