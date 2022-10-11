<?php
    session_start();
    include "bd.php";
    $habID = $_POST['habID'];
    $tipoID = $_POST['tipoID'];
    $nombreHab = $_POST['nombreHab'];
    $bd = new database();
    $bd->cambiarTipoHab($habID,$tipoID,$nombreHab);
    return "se ha cambiado correctamente";
?>