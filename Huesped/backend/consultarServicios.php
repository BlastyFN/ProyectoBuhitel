<?php 
    include "bdHuesped.php";
    $bd = new database();
    //FECHAS
    date_default_timezone_set('America/Mexico_City');
    $zonahoraria = date_default_timezone_get();
    $Hoy = date('Y-m-d H:i:s');
    //INIT
    header('Content-Type: application/json;');
    $info = file_get_contents('php://input');
    //Hacer JSON
    $nuevoJson = json_decode($info);
    //DETERMINAR CODIGO 
    $Habitacion = $nuevoJson->HID;
    //CONSULTAR BASE DE DATOS
    $resSP = $bd->consultarServicios($Hoy, $Habitacion, 1);
    $stringSP = "No hay servicios pendientes";
    if (isset($resSP[0])) {
        $stringSP = "Servicios pendientes: \n";
        foreach ($resSP as $key => $servicio) {
            $num = $key+1;
            $stringProductos="";
            $lproductos = $bd->consultarProductosServicio($servicio['Servicio_ID']);
            foreach ($lproductos as $key => $producto) {
                $stringProductos = $stringProductos." ".$producto['CarroProd_NumProductos']." ".$producto['Producto_Nombre'].",";
            }
            $stringProductos = substr($stringProductos, 0, -1);
            $stringSP = $stringSP.$num.".- Fecha: ".$servicio['Servicio_Fecha']." Con;".$stringProductos." por un total de $".$servicio['Servicio_PrecioTotal']."\n"; 
        }
    }
    $StringEC ="No hay servicios en curso";
    $resEC = $bd->consultarServicios($Hoy, $Habitacion, 2);
    if (isset($resEC[0])) {
        $StringEC = "Servicios en curso: \n";
        foreach ($resEC as $key => $servicio) {
            $num = $key+1;
            $stringProductos="";
            $lproductos = $bd->consultarProductosServicio($servicio['Servicio_ID']);
            foreach ($lproductos as $key => $producto) {
                $stringProductos = $stringProductos." ".$producto['CarroProd_NumProductos']." ".$producto['Producto_Nombre'].",";
            }
            $stringProductos = substr($stringProductos, 0, -1);
            $StringEC = $StringEC.$num.".- Fecha: ".$servicio['Servicio_Fecha']." Con;".$stringProductos." por un total de $".$servicio['Servicio_PrecioTotal']."\n";
        }
    }
    $status = true;

    
    

    //CREAR JSON PARA POSTEAR
    $arreglo = array(
        'serstatus' => $status,
        'pendientes' => $stringSP,
        'actuales' => $StringEC
    );
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);


    
?>