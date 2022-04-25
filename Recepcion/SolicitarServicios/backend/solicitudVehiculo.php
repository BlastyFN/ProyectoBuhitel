<?php 
    session_start();
    include "bdservicios.php";
    if (isset($_SESSION['sesionPersonal']['Hotel']) && isset($_POST['Placas']) && isset($_POST['Estatus'])){
        $bd = new database();
        $Placas = $_POST['Placas'];
        $Estatus = $_POST['Estatus'];
        $res = $bd->actualizarEstatus($Placas, $Estatus);
        echo $res;
    }

?>