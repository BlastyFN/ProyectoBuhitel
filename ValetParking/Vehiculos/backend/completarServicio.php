<?php 
    session_start();
    include "bdvehiculos.php";
    if (isset($_SESSION['sesionPersonal']['Hotel']) && isset($_POST['Placas'])){
        $bd = new database();
        $Placas = $_POST['Placas'];
        $res = $bd->completarServicio($Placas);
        echo $res;
    }

?>