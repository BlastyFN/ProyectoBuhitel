<?php
    session_start();
    include "bd.php";
    date_default_timezone_set('America/Mexico_City');
    $zonahoraria = date_default_timezone_get();
    $hoy = date('c');
    $hotel = $_SESSION['sesionPersonal']['Hotel'];
	$bd = new database();
    $d=rand(1,1);
    $res;
    $elemento;
    switch ($d) {
        case '1':
            $lista = $bd->obtenerProductoMasPedido($hotel);
            $elemento = $Lista[0]['Nombre'];
            $frase = "El producto más pedido es: " . $elemento;
        break;

        case '2':
            # $lista = $bd->obtenerProductoMenosPedido($hotel, $hoy);
            $frase = "El producto menos pedido es :". $elemento;
        break;

        case '3':
            # $lista = $bd->obtenerAreaMasReportada($hotel, $hoy);
            $frase = "El área más reportada es: " . $elemento;
        break;

        case '4':
            # $lista = $bd->obtenerTipoMasPedido($hotel, $hoy);
            $frase = "El tipo de habitación más reservado es: ". $elemento;
        break;

        case '5':
            # $lista = $bd->obtenerTipoMenosPedido($hotel, $hoy);
            $frase = "El tipo de habitación menos reservado es: ". $elemento;
        break;

        case '6':
            # $lista = $bd->obtenerCantidadDeReportes($hotel, $hoy);
            $frase = "En los últimos 30 días han habido ". $elemento . " reportes en tu hotel ";
        break;
        default:
            # defautl
        break;
    }
    

    echo ($frase);
    
?>