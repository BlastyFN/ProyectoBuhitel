<?php 
    session_start();
    include "bdReservacion.php";
    if (isset($_POST['Habitacion']) && isset($_POST['Reservacion'])) {
        $Habitacion = $_POST['Habitacion'];
        $Reservacion = $_POST['Reservacion'];
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $bd = new database();
        $regH = $bd->reservarHab($Reservacion, $Habitacion);
        $fechaInicio = $bd->consultarCheckout($Reservacion);
        $Tiempo = $bd->ConsultarTiempoLimpieza($Habitacion);
        //DETERMINAR FECHAS Y HORAS
        $v_HorasPartes = explode(":", $Tiempo);
        $minutosTotales= ($v_HorasPartes[0] * 60) + $v_HorasPartes[1];
        $fechaInicioNum = strtotime($fechaInicio);
        $fechaFinNum = $fechaInicioNum+($minutosTotales*60);
        $fechaFinal = date("Y-m-d H:i:s", $fechaFinNum);
        $horaInicio = date("H:i:s", $fechaInicioNum);
        $fechaDia = date("Y-m-d", $fechaInicioNum);
        $horaFinal = date("H:i:s", $fechaFinNum);
        //CONSULTAR PERSONAL DISPONIBLE
        $consultaPersonal = $bd->consultarPersonal($horaInicio, $horaFinal, $Hotel);
        if (isset($consultaPersonal[0])) {
            $limpiadores = [];
            //GENERAR LISTA DE PERSONAL
            foreach ($consultaPersonal as $key => $value) {
                $limpiador = [];
                $consultaLimpiezas = $bd->consultarLimpiezasPersonal($value["Personal_ID"], $fechaDia, $Hotel);
                $minutosAcumulados = 0;
                $npersonal = $key+1;
                foreach ($consultaLimpiezas as $num => $limpieza) {
                    $numFechaInicio = strtotime($limpieza["Limpieza_HoraInicio"]);
                    $numFechaFinal = strtotime($limpieza["Limpieza_HoraFin"]);
                    $numTiempo = $numFechaFinal - $numFechaInicio;
                    $minutosLimpieza = ($numTiempo/60);
                    $minutosAcumulados += $minutosLimpieza;
                }
                $limpiador['ID'] = $value["Personal_ID"];
                $limpiador['Nombre'] = $value["Personal_Nombre"];
                $limpiador['Apellidos'] = $value["Personal_APaterno"]." ".$value["Personal_AMaterno"];
                $limpiador['Minutos'] = $minutosAcumulados;
                array_push($limpiadores, $limpiador);
            }
            //DETERMINAR MÁS DESOCUPADo
            $personalOrdenado = array_sort($limpiadores, 'Minutos', SORT_ASC);
                $ordenDisponibles= [];
                $ordenGeneral = [];
                foreach ($personalOrdenado as $key => $usuario) {
                    $disponibilidad = $bd->consultarDisponbilidad($usuario['ID'], $fechaInicio, $fechaFinal);
                    if ($disponibilidad == "Disponible") {
                        array_push($ordenDisponibles, $key);
                    }
                    array_push($ordenGeneral, $key);
                    
                }
                if (isset($ordenDisponibles[0])) {
                    $registro = $bd->registrarLimpieza($Habitacion, $personalOrdenado[$ordenDisponibles[0]]['ID'], $fechaInicio, $fechaFinal, 'Profunda');
                }    
        }
        echo $regH;
    }

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