<?php 
    session_start();
    include "bdservicios.php";
    include "../../../Recursos/Twilio/buhi.php";
    if (isset($_SESSION['sesionPersonal']['Hotel']) && isset($_POST['Servicio'])){
        date_default_timezone_set('America/Mexico_City');
        $zonahoraria = date_default_timezone_get();
        $Hoy = date('Y-m-d H:i:s');
        $bd = new database();
        $Servicio = $_POST['Servicio'];
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $numero = $bd->obtenerNumero($Servicio, $Hoy);
        if ($numero != false) {
            $nuevostatus = $bd->obtenerStatus($Estatus);
            $mensajero = new buhi();
            $mensaje = "Hola! Aquí Buhi notificando que desafortunadamente tu pedido ha sido cancelado";
            $resultado = $mensajero->enviarMensaje($numero, $mensaje); 
        }
        $res = $bd->cancelarServicio($Hotel, $Servicio);
        echo $res;
    }

?>