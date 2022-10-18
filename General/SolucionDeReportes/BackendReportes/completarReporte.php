<?php
    include "bd.php";
    include "../../../Recursos/Twilio/buhi.php";
    session_start();
    $hotel = $_SESSION['sesionPersonal']['Hotel'];
   
    $idReporte = $_POST["reporte"];
    date_default_timezone_set('America/Mexico_City');
    $zonahoraria = date_default_timezone_get();
    $Hoy = date('Y-m-d H:i:s');

    $bd = new database();
    $bd->completarReporte($idReporte,$Hoy);
    
    $numero = $bd->obtenerNumero($idReporte);
    if ($numero != false) {
        $mensajero = new buhi();
        $mensaje = "Hola! Aquí Buhi notificando que tu reporte ha sido completado por parte del personal del hotel, puedes marcarlo como solucionado en el el menú de (Mis servicios) si así lo deseas.";
        $resultado = $mensajero->enviarMensaje($numero, $mensaje); 
    }
?>
