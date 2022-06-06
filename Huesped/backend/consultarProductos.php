<?php 
    include "bdHuesped.php";
    $bd = new database();
    //FECHAS
    date_default_timezone_set('America/Mexico_City');
    $zonahoraria = date_default_timezone_get();
    $Hoy = date('c');
    //INIT
    header('Content-Type: application/json;');
    $info = file_get_contents('php://input');
    //Hacer JSON
    $nuevoJson = json_decode($info);
    //DETERMINAR CODIGO 
    $Habitacion = $nuevoJson->HID;
    $Categoria = $nuevoJson->Categoria;
    //CONSULTAR BASE DE DATOS
    $status = false;
    $Hotel = $bd->consultarHotel($Habitacion);
    $res = $bd->consultarCategorias($Hotel);
    $arreglo;
    if (isset($res[$Categoria-1])) {
        $status = true;
        $contador = 0;
        $StringCategorias="Productos ".$res[$Categoria-1]['CatProd_Categoria']."\n" ;
        $prod = $bd->consultarProductos($res[$Categoria-1]['CatProd_ID']);
        foreach ($prod as $key => $producto) {
            $contador++;
            $StringCategorias = $StringCategorias . $contador . ".- " . $producto['Producto_Nombre'] ."  $".$producto['Producto_Precio']. "\n";
        }
        $arreglo = array(
            'catstatus' => $status,
            'productos' => $StringCategorias
        );
    }
    else{
        $arreglo = array('catstatus' => $status);
    }
    
    

    //CREAR JSON PARA POSTEAR
    
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);


    
?>