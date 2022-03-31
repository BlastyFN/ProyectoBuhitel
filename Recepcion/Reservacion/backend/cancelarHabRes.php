<?php 
    session_start();
    include "bdReservacion.php";
    if (isset($_POST['HabRes'])) {
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $HabRes = $_POST['HabRes'];
        $bd = new database();
        $res = $bd->cancelarHabRes($Hotel, $HabRes);
        echo $res;
    }
    else {
        echo 0;
    }
    
?>