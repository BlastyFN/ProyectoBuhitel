<?php
    session_start();
    include "bd.php";
    date_default_timezone_set('America/Mexico_City');
    $zonahoraria = date_default_timezone_get();
    $hoy = date('c');
    $hotel = $_SESSION['sesionPersonal']['Hotel'];
	$bd = new database();
    $d=rand(1,6);
    $res;
    $elemento;
    switch ($d) {
        case '1':
            //PRODUCTO MAS PEDIDO
            $lista = $bd->obtenerProductoPedidos($hotel);
            $listaOrdenada = array_sort($lista, 'Cantidad', SORT_DESC);
            $elemento = $listaOrdenada[array_key_first($listaOrdenada)];
            $frase = "El producto más pedido es: " . $elemento['Nombre'] . " con un total de " .$elemento['Cantidad']. " unidades solicitadas";

        break;

        case '2':
            //PRODUCTO MENOS PEDIDO
            $lista = $bd->obtenerProductoPedidos($hotel);
            $listaOrdenada = array_sort($lista, 'Cantidad', SORT_ASC);
            $elemento = $listaOrdenada[array_key_first($listaOrdenada)];
            $frase = "El producto menos pedido es: " . $elemento['Nombre'] . " con un total de " .$elemento['Cantidad']. " unidades solicitadas";
        break;

        case '3':
            //CATEGORIA MAS REPORTADA
            $lista = $bd->obtenerCategoriasReportadas($hotel);
            $listaOrdenada = array_sort($lista, 'Cantidad', SORT_DESC);
            $elemento = $listaOrdenada[array_key_first($listaOrdenada)];
            $frase = "La categoría más reportada es: " . $elemento['Nombre'] . " con un total de ". $elemento['Cantidad']. " reportes";
        break;

        case '4':
            //CATEGORIA MENOS REPORTADA
            $lista = $bd->obtenerCategoriasReportadas($hotel);
            $listaOrdenada = array_sort($lista, 'Cantidad', SORT_ASC);
            $elemento = $listaOrdenada[array_key_first($listaOrdenada)];
            $frase = "La categoría menos reportada es: " . $elemento['Nombre'] . " con un total de ". $elemento['Cantidad']. " reportes";
        break;

        case '5':
            //TIPO HABITACIÓN MÁS RESERVADA
            $lista = $bd->obtenerTiposHabReservadas($hotel);
            $listaOrdenada = array_sort($lista, 'Cantidad', SORT_DESC);
            $elemento = $listaOrdenada[array_key_first($listaOrdenada)];
            $frase = "El tipo de habitación más reservado es: ". $elemento['Nombre'] . " con un total de " . $elemento['Cantidad'] . " reservaciones";
        break;

        case '6':
            //TIPO HABITACIÓN MENOS RESERVADA
            $lista = $bd->obtenerTiposHabReservadas($hotel);
            $listaOrdenada = array_sort($lista, 'Cantidad', SORT_ASC);
            $elemento = $listaOrdenada[array_key_first($listaOrdenada)];
            $frase = "El tipo de habitación menos reservado es: ". $elemento['Nombre'] . " con un total de " . $elemento['Cantidad'] . " reservaciones";
        break;
        default:
            # defautl
        break;
    }
    

    echo ($frase);


    function array_sort($array, $on, $order=SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                break;
                case SORT_DESC:
                    arsort($sortable_array);
                break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }
        return $new_array;
    }
?>