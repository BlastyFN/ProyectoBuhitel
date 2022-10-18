<?php
    include "bd.php";
    session_start();
    $personal =  $_SESSION['sesionPersonal']['ID'];
	
    $bd = new database();
    $res = $bd->obtenerReportesNoLeidos($personal);
    echo json_encode($res);


?>