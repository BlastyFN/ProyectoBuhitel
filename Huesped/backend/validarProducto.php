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
    //DETERMINAR VARIABLES 
    $Habitacion = $nuevoJson->HID;
    $Categoria = $nuevoJson->Categoria;
    $Producto = $nuevoJson->Producto;
    
    //CONSULTAR BASE DE DATOS
    $status = false;
    $Hotel = $bd->consultarHotel($Habitacion);
    $res = $bd->consultarCategorias($Hotel);
    $arreglo;
    if (isset($res[$Categoria-1])) {
        $contador = 0;
        $prod = $bd->consultarProductos($res[$Categoria-1]['CatProd_ID']);
        if (isset($prod[$Producto-1])) {
            $status = true;
            $arreglo = array(
                'prostatus' => $status,
                'producto' => $prod[$Producto-1]['Producto_Nombre'],
                'prodid' => $prod[$Producto-1]['Producto_ID']
            );
        }
        else{
            $arreglo = array('prostatus' => $status);
        }
        
    }
    else{
        $arreglo = array('prostatus' => $status);
    }
    

    //CREAR JSON PARA POSTEAR
    
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);
    

    
?>