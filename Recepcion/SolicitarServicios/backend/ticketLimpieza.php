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
            
            printf("ID de habitacion: ".$id."\n");
            print_r("Duracion Limpieza: ".$tiempoLimpieza."\n");
            print_r("Total minutos limpieza: ".$minutosTotales."\n"); 
            print_r("Fecha programada: ".$fechaDia."\n");
            print_r("Inicio programado: ".$fechaInicio."\n");
            print_r("Final programado: ".$fechaFinal."\n");
            if (isset($consultaPersonal[0] )) {
                $limpiadores = [];
                print_r("Hay un total de ".sizeof($consultaPersonal)." elementos del personal que trabajan durante ese tiempo \n");
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
                    print_r("--------------------- \n");
                    print_r("NUM: ".$key. "\n");
                    print_r("ID: ".$usuario['ID']. "\n");
                    print_r("Nombre: ".$usuario['Nombre']. "\n");
                    print_r("Minutos: ".$usuario['Minutos']. "\n");
                    print_r("Disponbilidad: ".$disponibilidad."\n");
                }
                print_r("--------------------- \n");
                if (isset($ordenDisponibles[0])) {
                    print_r("El usuario disponbile más desocupado es: ".$personalOrdenado[$ordenDisponibles[0]]['Nombre']."\n");
                    $registro = $bd->registrarLimpieza($id, $personalOrdenado[$ordenDisponibles[0]]['ID'], $fechaInicio, $fechaFinal, 'Normal');
                    print_r($registro. "\n");
                }
                else{
                    $PeriodosInternos = [];
                    print_r("No hay nadie desocupado en ese periodo \n");
                    print_r("El más desocupado en general es: ".$personalOrdenado[$ordenGeneral[0]]['Nombre'] ."\n");
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
                        foreach ($consultaLimpiezasPeriodo as $num => $limpieza) {
                            $ocupacion['Personal'] = $limpieza['Personal_ID'];
                            $ocupacion['LimiteSuperior'] = $limpieza['Limpieza_HoraInicio'];
                            $ocupacion['LimiteInferior'] = $limpieza['Limpieza_HoraFin'];
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
                            if ($trabajador['Presencia'] == true) {
                                $contadorTrabajadoresDiferentes++;
                            }
                        }
                        print_r("Limpieza de : ".$limpieza["Limpieza_HoraInicio"] ." a ".$limpieza["Limpieza_HoraFin"]. " tiene ".$contadorTrabajadoresDiferentes." de ".count($personalActivo)." usuarios que trabajan a esa hora \n");
                        
                        if ($contadorTrabajadoresDiferentes == count($personalActivo)) {
                            print_r("Periodo totalmente ocupado, necesidad de determinar límites superiores e inferiores \n");
                            //LIMITES SUPERIORES
                            $LimitesSuperioresValidos = [];
                            print_r("------------------- LIMITES SUPERIORES ------------------- \n");
                            foreach ($FilaOcupaciones as $iteracion => $ocupa) {
                                $LimiteSuperiorNumerico = (strtotime($ocupa['LimiteSuperior']) - 60);
                                $InicioPractico = date("Y-m-d H:i:s", $LimiteSuperiorNumerico);
                                $FinalPractico = date("Y-m-d H:i:s", $LimiteSuperiorNumerico - (60*$minutosTotales));
                                $disponibilidad = $bd->consultarDisponbilidad($ocupa['Personal'], $InicioPractico, $FinalPractico);
                                print_r("LIMITE: ".$ocupa['LimiteSuperior']." VALIDEZ: ".$disponibilidad." \n");
                                if ($disponibilidad == "Disponible") {
                                    array_push($LimitesSuperioresValidos, $LimiteSuperiorNumerico);
                                }
                            }
                            print_r("------------------- LIMITES SUPERIORES ------------------- \n");
                            $LimitesInferioresValidos = [];
                            print_r("------------------- LIMITES INFERIORES ------------------- \n");
                            foreach ($FilaOcupaciones as $iteracion => $ocupa) {
                                $LimiteInferiorNumerico = (strtotime($ocupa['LimiteInferior']) + 60);
                                $InicioPractico = date("Y-m-d H:i:s", $LimiteInferiorNumerico);
                                $FinalPractico = date("Y-m-d H:i:s", $LimiteInferiorNumerico + (60*$minutosTotales));
                                $disponibilidad = $bd->consultarDisponbilidad($ocupa['Personal'], $InicioPractico, $FinalPractico);
                                print_r("LIMITE: ".$ocupa['LimiteInferior']." VALIDEZ: ".$disponibilidad." \n");
                                if ($disponibilidad == "Disponible") {
                                    array_push($LimitesInferioresValidos, $LimiteInferiorNumerico);
                                }
                            }
                            print_r("------------------- LIMITES INFERIORES ------------------- \n");
                            $OrdenadosSuperioresValidos = $LimitesSuperioresValidos;
                            //ORDENAR SUPERIORES DE MÁS GRANDE A MAS CHICO (MÁS TARDE A MAS TEMPRANO)
                            rsort($OrdenadosSuperioresValidos);
                            $OrdenadosInferioresValidos = $LimitesInferioresValidos;
                            //ORDENAR INFERIORES DE MÁS CHICO A MAS GRANDE (MÁS TEMPRANO A MAS TARDE)
                            sort($OrdenadosInferioresValidos);
                            //EN CASO DE QUE EXISTA SUPERIOR VALIDO
                            if (isset($OrdenadosSuperioresValidos[0])) {
                                if (isset($OrdenadosInferioresValidos[0])) {
                                    //EN CASO DE QUE EXISTAN SUPERIORES E INFERIORES VALIDOS
                                    $SuperiorMasTarde = $OrdenadosSuperioresValidos[0];
                                    $InferiorMasTemprano = $OrdenadosInferioresValidos[0];
                                    $FechaSuperior = date("Y-m-d H:i:s", $SuperiorMasTarde);
                                    $FechaInferior = date("Y-m-d H:i:s", $InferiorMasTemprano);
                                    print_r("Superior más tarde: ".$FechaSuperior." \n");
                                    print_r("Inferior más temprano: ".$FechaInferior." \n");
                                    if ($SuperiorMasTarde > $InferiorMasTemprano) {
                                        //CREAR UN CAMPO ENTRE ESOS DOS
                                        array_push($PeriodosInternos, $SuperiorMasTarde);
                                        array_push($PeriodosInternos, $InferiorMasTemprano);
                                        
                                    }
                                    else {
                                        //CREAR DOS; UNO DEL SUPERIOR PRINCIPAL AL INFERIOR MAS ALTO Y OTRO DEL SUPERIOR MAS BAJO AL INFERIOR PRINCIPAL
                                        // array_push($PeriodosInternos, strtotime($limpieza["Limpieza_HoraInicio"]));
                                        // array_push($PeriodosInternos, $InferiorMasTemprano);
                                        // array_push($PeriodosInternos, $SuperiorMasTarde);
                                        // array_push($PeriodosInternos, strtotime($limpieza["Limpieza_HoraFin"]));
                                        
                                        
                                    }
                                }
                                else{
                                    //EN CASO DE QUE EXISTA SUPERIOR VALIDO PERO INFERIOR NO
                                    $Techo = date("Y-m-d H:i:s", $OrdenadosSuperioresValidos[0]);
                                }
                            }
                            else{
                                //EN CASO DE QUE EXISTA INFERIOR VALIDO AUNQUE SUPERIOR NO
                                if (isset($OrdenadosInferioresValidos[0])) {
                                    $Techo = date("Y-m-d H:i:s", $OrdenadosInferioresValidos[0]);
                                }
                                
                            }
                            
                            
                        }
                        // var_dump($consultaLimpiezasPeriodo);
                    }
                    print_r("DISPONIBLE desde: ".$Techo." \n");
                    sort($PeriodosInternos);
                    foreach ($PeriodosInternos as $num => $periodo) {
                        $p;
                        if (($num % 2) == 0) {
                            $p = "pausa";
                        }
                        else {
                            $p = "play";
                        }
                        $PeriodoFecha = date("Y-m-d H:i:s", $periodo);
                        print_r($PeriodoFecha." ".$p." \n");
                    }
                    print_r("HASTA LAS : ".$Suelo." \n");
                }
                
            }
            else {
                print_r("--------------------- \n");
                print_r("No hay personal trabajando en esa hora \n");
                print_r("--------------------- \n");
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