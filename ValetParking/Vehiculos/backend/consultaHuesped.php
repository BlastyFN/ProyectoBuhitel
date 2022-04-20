<?php 
    session_start();
    include "bdvehiculos.php";
    if (isset($_POST['Habitacion']) && isset($_POST['Placas']) && isset($_POST['Modelo']) && isset($_POST['Color']) && isset($_POST['Notas']) && isset($_POST['Lugar'])) {
        date_default_timezone_set('America/Mexico_City');
        $zonahoraria = date_default_timezone_get();
        $hoy = date('c');
        $Habitacion = $_POST['Habitacion'];
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $bd = new database();
        $res = $bd->consultarHuesped($Hotel, $Habitacion, $hoy);
        if (isset($res[0])) {
            $Placas = $_POST['Placas'];
            $Modelo = $_POST['Modelo'];
            $Color = $_POST['Color'];
            $Lugar = $_POST['Lugar'];
            $Huesped = $res[0]['Reservacion_Huesped'];
            $Habitacion = $res[0]['HabReservada_ID'];
            $Notas = $_POST['Notas'];
            echo($Habitacion);
            echo($Huesped);
            echo ($Lugar);
            $res2 = $bd->registrarVehiculo($Placas, $Huesped, $Habitacion, $Modelo, $Color, $Lugar, $Notas);
            
        }
        else {
            echo 0;
        }
    }

?>