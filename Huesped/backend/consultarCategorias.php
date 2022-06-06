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
    //CONSULTAR BASE DE DATOS
    $status = false;
    $Hotel = $bd->consultarHotel($Habitacion);
    $res = $bd->consultarCategorias($Hotel);
    $arreglo;
    if (isset($res[0])) {
        $status = true;
        $contador = 0;
        $StringCategorias="Categorías: \n";
        foreach ($res as $key => $cat) {
            $contador++;
            $StringCategorias = $StringCategorias . $contador . ".- " . $cat['CatProd_Categoria'] . "\n";
        }
        $arreglo = array(
            'catstatus' => $status,
            'categorias' => $StringCategorias
        );
    }
    else{
        $arreglo = array('catstatus' => $status);
    }
    
    

    //CREAR JSON PARA POSTEAR
    
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);


    
?>