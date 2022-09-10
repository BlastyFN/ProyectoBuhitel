<?php
    session_start();
    include "bd.php";
    $habID = $_POST['habID'];
    $tipoID = $_POST['tipoID'];
    $bd = new database();
    $db->cambiarTipoHab($habID,$tipoID);

?>