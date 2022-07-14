<?php 
    session_start();
    include "bd.php";
    include "../../../Recursos/Twilio/buhi.php";
    if (isset($_SESSION['sesionPersonal']['Hotel']) && isset($_POST['Limpieza']) && isset($_POST['Notas']) && isset($_POST['Estatus'])){
        date_default_timezone_set('America/Mexico_City');
        $zonahoraria = date_default_timezone_get();
        $Hoy = date('Y-m-d H:i:s');
        $bd = new database();
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $Limpieza = $_POST['Limpieza'];
        $Notas = $_POST['Notas'];
        $Estatus = $_POST['Estatus'];
        $res = $bd->cambiarEstatus($Limpieza, $Notas, $Estatus);
        $numero = $bd->obtenerNumero($Limpieza, $Hoy);
        if ($numero != false) {
            $nuevostatus;
            switch ($Estatus) {
                case '2':
                    $nuevostatus = "En proceso";
                    break;
                case '3':
                    $nuevostatus = "Completada";
                    break;
                
                default:
                    # code...
                    break;
            }
            $mensajero = new buhi();
            $mensaje = "Hola! Aquí Buhi notificando que la limpieza de tu habitación ha cambiado de estatus a: ".$nuevostatus;
            $resultado = $mensajero->enviarMensaje($numero, $mensaje); 
        }

        echo $res;
    }

?>