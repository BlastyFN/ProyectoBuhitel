<?php 
    session_start();
    include "bdTwilio.php";
    if (isset($_POST['Pregunta'])) {
        $bd = new database();
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $Campo = $_POST['Campo'];
        $Valor = $_POST['Valor'];
        $res = $bd->actualizarEstado($Hotel, $Campo, $Valor);
        echo $res;
    }
    else{
        echo "0";
    }
    
?>