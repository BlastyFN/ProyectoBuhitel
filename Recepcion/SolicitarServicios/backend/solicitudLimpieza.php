<?php 
    session_start();
    include "bdservicios.php";
    if (isset($_POST['Habitacion']) && isset($_POST['Fecha'])){
        date_default_timezone_set('America/Mexico_City');
        $zonahoraria = date_default_timezone_get();
        $bd = new database();
        $Habitacion = $_POST['Habitacion'];
        $Fecha = $_POST['Fecha'];
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $consultaID = $bd->verificarOcupacion($Habitacion, $Fecha, $Hotel);
        $id;
        $tiempoLimpieza;
        if (isset($consultaID[0])) {
            $id = $consultaID[0][0];
            $tiempoLimpieza = $consultaID[0][1];
            $fechaPartes = explode("T", $Fecha);
            $fechaDia = $fechaPartes[0];
            $fechaInicioNum = strtotime($Fecha);
            $fechaInicio = date("Y-m-d H:i:s", $fechaInicioNum);
            $horaInicio = date("H:i:s", $fechaInicioNum);
            $v_HorasPartes = explode(":", $tiempoLimpieza);
            $minutosTotales= ($v_HorasPartes[0] * 60) + $v_HorasPartes[1];         
            $fechaFinNum = $fechaInicioNum+($minutosTotales*60);
            $fechaFinal = date("Y-m-d H:i:s", $fechaFinNum);
            $horaFinal = date("H:i:s", $fechaFinNum);
            $consultaPersonal = $bd->consultarPersonal($horaInicio, $horaFinal, $Hotel);
            if (isset($consultaPersonal[0] )) {
                $limpiadores = [];
                //GENERAR LISTA DE PERSONAL
                foreach ($consultaPersonal as $key => $value) {
                    $limpiador = [];
                    $consultaLimpiezas = $bd->consultarLimpiezasPersonal($value["Personal_ID"], $fechaDia, $Hotel);
                    $minutosAcumulados = 0;
                    $npersonal = $key+1;
                    // print_r("Num de personal: ".$npersonal."\n");
                    // print_r("Nombre: ".$value["Personal_Nombre"]."\n");
                    // print_r("ID: ".$value["Personal_ID"]."\n");
                    // print_r("LIMPIEZAS:\n");
                    foreach ($consultaLimpiezas as $num => $limpieza) {
                        $numFechaInicio = strtotime($limpieza["Limpieza_HoraInicio"]);
                        $numFechaFinal = strtotime($limpieza["Limpieza_HoraFin"]);
                        $numTiempo = $numFechaFinal - $numFechaInicio;
                        $minutosLimpieza = ($numTiempo/60);
                        $minutosAcumulados += $minutosLimpieza;
                    }
                    // print_r("Total de: ".$minutosAcumulados." minutos acumulados \n");
                    $limpiador['ID'] = $value["Personal_ID"];
                    $limpiador['Nombre'] = $value["Personal_Nombre"];
                    $limpiador['Apellidos'] = $value["Personal_APaterno"]." ".$value["Personal_AMaterno"];
                    $limpiador['Minutos'] = $minutosAcumulados;
                    array_push($limpiadores, $limpiador);
                }
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
                    $registro = $bd->registrarLimpieza($id, $personalOrdenado[$ordenDisponibles[0]]['ID'], $fechaInicio, $fechaFinal, 'Normal');
                    $DatosLimpieza['Habitacion'] = $Habitacion;
                    $DatosLimpieza['Nombre'] = $personalOrdenado[$ordenDisponibles[0]]['Nombre'];
                    $DatosLimpieza['Apellidos'] = $personalOrdenado[$ordenDisponibles[0]]['Apellidos'];
                    $DatosLimpieza['Inicio'] = $fechaInicio;
                    $DatosLimpieza['Final'] = $fechaFinal;
                    $DatosLimpieza['ID'] = $registro;
                    $JSONLIMPIEZA = json_encode($DatosLimpieza);
                    echo($JSONLIMPIEZA);
                    
                    // print_r($registro);
                }
                else{
                    $PeriodosInternos = [];
                    //CONSULTAR LIMPIEZAS DEL MÁS DESOCUPADO
                    $ColumnaPrincipalOcupaciones = $bd->consultarLimpiezasPersonal($personalOrdenado[$ordenGeneral[0]]['ID'], $fechaDia, $Hotel);
                    //CONSULTAR HORARIO DEL MÁS DESOCUPADO
                    $horarioPrincipal = $bd->consultarHorario($personalOrdenado[$ordenGeneral[0]]['ID']);
                    //DETERMINAR VARIABLES DE HORARIO
                    $Techo = $horarioPrincipal['InfoLimpieza_InicioJornada'];
                    $Suelo = $horarioPrincipal['InfoLimpieza_FinJornada'];
                    $DescansoInicio = $horarioPrincipal['InfoLimpieza_InicioDescanso'];
                    $DescansoFinal = $horarioPrincipal['InfoLimpieza_FinDescanso'];
                    $Descanso['Limpieza_HoraInicio'] = $fechaDia." ".$DescansoInicio;
                    $Descanso['Limpieza_HoraFin'] = $fechaDia." ".$DescansoFinal;
                    array_push($PeriodosInternos, strtotime($Techo));
                    array_push($PeriodosInternos, strtotime($Suelo));
                    array_push($ColumnaPrincipalOcupaciones, $Descanso);
                    //RECORRIDO DE LIMPIEZAS DE PERSONAL
                    // print_r($horarioPrincipal);
                    foreach ($ColumnaPrincipalOcupaciones as $key => $limpieza) {
                        $FilaOcupaciones = [];
                        //CONSULTAR LAS LIMPIEZAS QUE CHOQUEN CON EL PERIODO DE LA LIMPIEZA PARTICULAR
                        $consultaLimpiezasPeriodo = $bd->consultarLimpiezasPeriodo($Hotel, $limpieza["Limpieza_HoraInicio"], $limpieza["Limpieza_HoraFin"]);
                        //CONSULTAR DESCANSOS PERIODO
                        $InicioPartes = explode(" ", $limpieza["Limpieza_HoraInicio"]);
                        $FinalPartes = explode(" ", $limpieza["Limpieza_HoraFin"]);
                        $consultaDescansosPeriodo = $bd->consultarDescansosPeriodo($Hotel, $InicioPartes[1], $FinalPartes[1]);
                        //CONSULTAR PERSONAL QUE ESTA ACTIVO A ESA HORA
                        $personalActivo = $bd->consultarPersonalSinDescansos($Hotel, $InicioPartes[1], $FinalPartes[1]);
                        //LLENAR EL ARREGLO DE OCUPACIONES
                        foreach ($consultaLimpiezasPeriodo as $num => $limpiezax) {
                            $ocupacion['Personal'] = $limpiezax['Personal_ID'];
                            $ocupacion['LimiteSuperior'] = $limpiezax['Limpieza_HoraInicio'];
                            $ocupacion['LimiteInferior'] = $limpiezax['Limpieza_HoraFin'];
                            array_push($FilaOcupaciones, $ocupacion);
                        }
                        foreach ($consultaDescansosPeriodo as $num => $descanso) {
                            $ocupacion['Personal'] = $descanso['InfoLimpieza_Personal'];
                            $ocupacion['LimiteSuperior'] = $fechaDia." ".$descanso['InfoLimpieza_InicioDescanso'];
                            $ocupacion['LimiteInferior'] = $fechaDia." ".$descanso['InfoLimpieza_FinDescanso'];
                            array_push($FilaOcupaciones, $ocupacion);
                        }
                        //RECORRER LAS OCUPACIONES PARA DETERMINAR CUALES NECESITAN EVALUACION DE LIMITES
                        foreach ($FilaOcupaciones as $iteracion => $ocupa) {
                            //RECORRER EL PERSONAL ACTIVO
                            foreach ($personalActivo as $key => $trabajador) {
                                
                                if ($ocupa['Personal'] == $trabajador['Personal_ID']) {
                                    $personalActivo[$key]['Presencia'] = true;
                                }
                               
                            }
                        }
                        $contadorTrabajadoresDiferentes = 0;
                        foreach ($personalActivo as $n => $trabajador) {
                            if (isset($trabajador['Presencia'])) {
                                if ($trabajador['Presencia'] == true) {
                                    $contadorTrabajadoresDiferentes++;
                                }
                            }

                            
                        }
                        //SI LOS TRABAJADORES ES IGUAL A LAS OCUPACIONES
                        if ($contadorTrabajadoresDiferentes == count($personalActivo)) {
                            
                            array_push($PeriodosInternos, strtotime($limpieza["Limpieza_HoraInicio"]));
                            array_push($PeriodosInternos, strtotime($limpieza["Limpieza_HoraFin"]));

                        }
                        // var_dump($consultaLimpiezasPeriodo);
                    }
                    
                    sort($PeriodosInternos);
                    $ArregloFechas = [];
                    foreach ($PeriodosInternos as $num => $periodo) {
                        
                        $PeriodoFecha = date("Y-m-d H:i:s", $periodo);
                        array_push($ArregloFechas, $PeriodoFecha);
                    }
                    $PeriodosJSON = json_encode($ArregloFechas);
                    echo $PeriodosJSON;
                }
                
            }
            else {
                echo("NP");
            }


            // for ($i=$fechaInicioNum; $i <= $fechaFinNum; $i+=60) { 
            //     $Fecha = date("c", $i);
            //     print_r("minuto: ".$Fecha."\n");
            // }

        }
        else{
            echo 0;
        }
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