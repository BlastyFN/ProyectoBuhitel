<?php 
    session_start();
    include "bdservicios.php";
    if (isset($_POST['Habitacion'])) {
        date_default_timezone_set('America/Mexico_City');
        $zonahoraria = date_default_timezone_get();
        $Hoy = date('Y-m-d H:i:s');
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $Habitacion = $_POST['Habitacion'];
        $bd = new database();
        $res = $bd->consultarOcupacion($Hotel, $Habitacion, $Hoy);
        if (isset($res[0])) {
            $info = json_encode($res[0]);
            echo $info;        
        }
        else{
            echo 0;
        }
        
    }
    else {
        echo "x";
    }
    
?>