<?php 
    session_start();
    include "bdPrincipal.php";
    date_default_timezone_set('America/Mexico_City');
    $zonahoraria = date_default_timezone_get();
    $Hoy = date('Y-m-d H:i:s');
    $Hotel = $_SESSION['sesionPersonal']['Hotel'];
    $bd = new database();
    $Tipos = $bd->consultarTipos($Hotel);
    $ListaTipos;
    foreach ($Tipos as $key => $tipo) {
        $THAB = [];
        $THAB['ID'] = $tipo['TipoHab_ID'];
        $THAB['Nombre'] = $tipo['TipoHab_Nombre'];
        $THAB['Cantidad'] = 0;
    }

    foreach ($ListaTipos as $key => $NTIPO) {
        $Totales = $bd->consultarHabsTipo($NTIPO['ID']);
        $Ocupadas = $bd->consultarHabsOcupadas($NTIPO['ID']);
        $NTIPO['Cantidad'] = count($Totales) - count($Ocupadas);
    }
    
    
    echo json_encode($ListaTipos);

?>