<?php 
    session_start();
    include "bdReservacion.php";
    if(isset($_POST['Tipo']) && isset($_POST['CIN']) && isset($_POST['COUT'])){
        date_default_timezone_set('America/Mexico_City');
        $zonahoraria = date_default_timezone_get();
        $CIN = strtotime($_POST['CIN']);
        $COUT = strtotime($_POST['COUT']);
        $Tipo = $_POST['Tipo'];
        // echo $CIN;
        // echo '<br>';
        // echo $COUT;
        $bd = new database();
        $habitaciones =  $bd->consultaHabitaciones($Tipo, 1);
        $Disponibles = [];
        foreach ($habitaciones as $dato) {
            $Habitacion = $dato['Habitacion_ID'];
            $disponibilidad = true;
            for ($i=$CIN; $i <= $COUT; $i+=86400) { 
                $Fecha = date("c", $i);
                $estatus = $bd->consultarDisponibilidad($Habitacion, $Fecha);

                if ($estatus == 'false') {
                    $disponibilidad = false;
                }
            }
            if ($disponibilidad == true) {
                array_push($Disponibles, $dato);
            }

        }
        $res = json_encode($Disponibles);
        echo($res);
        
    }

?>