<?php 
    session_start();
    include "bdPrincipal.php";
    date_default_timezone_set('America/Mexico_City');
    $zonahoraria = date_default_timezone_get();
    $Hoy = date('Y-m-d');
    $NumHoy = strtotime($Hoy);
    $NumManana = $NumHoy + 86400;
    $Mañana = date('Y-m-d', $NumManana);
    $Hotel = $_SESSION['sesionPersonal']['Hotel'];
    $bd = new database();
    $CINS = $bd->consultarCINS($Hotel, $Hoy, $Mañana);
    $numCINS = count($CINS);
    $COTS = $bd->consultarCOTS($Hotel, $Hoy, $Mañana);
    $numCOTS = count($COTS);
    $arreglo = array(
        'CINS' => $numCINS,
        'COTS' => $numCOTS
    );
    $JSON = json_encode($arreglo);
    print_r($JSON);

?>