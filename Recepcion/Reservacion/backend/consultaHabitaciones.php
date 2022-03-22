<?php 
    session_start();
    include "bdReservacion.php";
    if(isset($_POST['Tipo'])){
        $bd = new database();
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $Tipo = $_POST['Tipo'];
        $ex = $bd->consultaTiposEnHotel($Tipo, $Hotel);
        if ($ex==true) {
            $res = $bd->consultaHabitaciones($Tipo, 1);
            if (isset($res[0])) {
                $datos = json_encode($res);
                echo $datos;
            }
            else {
                echo 0;
            }
        }
        else{
            echo 1;
        }
        
    }

?>