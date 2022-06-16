<?php 
    session_start();
    include "bdPrincipal.php";
    date_default_timezone_set('America/Mexico_City');
    $zonahoraria = date_default_timezone_get();
    $Hoy = date('Y-m-d H:i:s');
    $Hotel = $_SESSION['sesionPersonal']['Hotel'];
    $bd = new database();
    $habitaciones = $bd->consultaHabitaciones($Hotel);
    $numHabs = count($habitaciones);
    $reservadas = $bd->consultarReservadas($Hotel, $Hoy);
    $numReservadas = count($reservadas);
    $Ocupacion = $numReservadas / $numHabs;
    echo $Ocupacion;

?>