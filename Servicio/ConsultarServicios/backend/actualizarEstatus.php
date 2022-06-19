<?php 
    session_start();
    include "bdservicios.php";
    include "/../../../Recursos/Twilio/buhi.php";
    if (isset($_SESSION['sesionPersonal']['Hotel']) && isset($_POST['Estatus']) && isset($_POST['Servicio'])){
        $bd = new database();
        $Estatus = $_POST['Estatus'];
        $Servicio = $_POST['Servicio'];
        $res = $bd->actualizarEstatus($Servicio, $Estatus);
        $mensajero = new buhi();
        $numero = "5213311177391";
        $mensaje = "Holaa";
        $resultado = $mensajero->enviarMensaje($numero, $mensaje); 
        echo $Estatus;
    }

?>