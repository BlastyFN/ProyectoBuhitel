<?php
    session_start();
    include "bd.php";
    $habID = $_POST['habID'];
    $habEstado = $_POST['habEstado'];

    if($habEstado == '1'){
        $habEstado = '0';
    } else {
        $habEstado = '1';
    }
   
    $bd = new database();
    $bd->cambiarEstadoHab($habID,$habEstado);
    return "se ha cambiado el estado";
?>