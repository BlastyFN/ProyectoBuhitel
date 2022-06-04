<?php 
    include "bdHuesped.php";
    $bd = new database();
    //FECHAS
    date_default_timezone_set('America/Mexico_City');
    $zonahoraria = date_default_timezone_get();
    $hoy = date('Y-m-d');
    //INIT
    header('Content-Type: application/json;');
    $info = file_get_contents('php://input');
    //Hacer JSON 
    $nuevoJson = json_decode($info);
    //OBTENER HID 
    $HID = $nuevoJson->HID;
    //DETERMINAR Hora
    $StatusHora = false;
    $Hora = $nuevoJson->hora;
    if (strlen($Hora) == 5) {
        if (strpos($Hora, ":") == 2) {
            $PartesHora = explode(":", $Hora);
            $Horas = $PartesHora[0];
            $Minutos = $PartesHora[1];
            if (is_numeric($Horas) && is_numeric($Minutos)) {
                if ($Horas >= 0 && $Horas < 24 && $Minutos >= 0 && $Minutos < 60) {
                    $NumFechaInicio = strtotime($hoy) + (($Horas*3600)+($Minutos*60));
                    $StrFechaInicio = date("Y-m-d H:i", $NumFechaInicio);
                    $StatusHora = true;
                }
                
            }
        }
    }
    $arreglo;
    if ($StatusHora == true) {
        $consultaTiempo = $bd->verificarOcupacion($HID, $StrFechaInicio);
        //Verificar disponibilidad de habitación
        if (isset($consultaTiempo[0])) {
            $TiempoLimpieza = $consultaTiempo[0]['TipoHab_TiempoLimpNormal'];
            $Hotel = $consultaTiempo[0]['TipoHab_Hotel'];
            $PartesTiempoLimpieza = explode(":", $TiempoLimpieza);
            $HorasTiempoLimpieza = $PartesTiempoLimpieza[0];
            $MinutosTiempoLimpieza = $PartesTiempoLimpieza[1];
            $MinutosTotalesLimpieza = ($HorasTiempoLimpieza * 60) + $MinutosTiempoLimpieza;
            $StrFechaFin = date("Y-m-d H:i", $NumFechaInicio+($MinutosTotalesLimpieza*60));
            $PartesFechaInicio = explode(" ", $StrFechaInicio);
            $PartesFechaFin = explode(" ", $StrFechaFin);
            $fechaDia = $PartesFechaInicio[0];
            $HoraInicioLimpieza = $PartesFechaInicio[1];
            $HoraFinLimpieza = $PartesFechaFin[1];
            $consultaPersonal = $bd->consultarPersonal($HoraInicioLimpieza, $HoraFinLimpieza, $Hotel);
            //Verificar que exista personal sin descansos ahí
            if (isset($consultaPersonal[0])) {
                $limpiadores = [];
                //GENERAR LISTA DE PERSONAL
                foreach ($consultaPersonal as $key => $value) {
                    $limpiador = [];
                    //Consultar las limpiezas de cada personal que trabaja a esa hora
                    $consultaLimpiezas = $bd->consultarLimpiezasPersonal($value["Personal_ID"], $fechaDia, $Hotel);
                    $minutosAcumulados = 0;
                    $npersonal = $key+1;
                    //Determinar los minutos que trabaja cada integrante del personal
                    foreach ($consultaLimpiezas as $num => $limpieza) {
                        $numFechaInicio = strtotime($limpieza["Limpieza_HoraInicio"]);
                        $numFechaFinal = strtotime($limpieza["Limpieza_HoraFin"]);
                        $numTiempo = $numFechaFinal - $numFechaInicio;
                        $minutosLimpieza = ($numTiempo/60);
                        $minutosAcumulados += $minutosLimpieza;
                    }
                    //Agregar al array de personal de limpieza
                    $limpiador['ID'] = $value["Personal_ID"];
                    $limpiador['Nombre'] = $value["Personal_Nombre"];
                    $limpiador['Apellidos'] = $value["Personal_APaterno"]." ".$value["Personal_AMaterno"];
                    $limpiador['Minutos'] = $minutosAcumulados;
                    array_push($limpiadores, $limpiador);
                }
                //Ordenar limpiadores
                $personalOrdenado = array_sort($limpiadores, 'Minutos', SORT_ASC);
                $ordenDisponibles= [];
                $ordenGeneral = [];
                //Definir disponibles de ellos
                foreach ($personalOrdenado as $key => $usuario) {
                    $disponibilidad = $bd->consultarDisponbilidad($usuario['ID'], $StrFechaInicio, $StrFechaFin);
                    if ($disponibilidad == "Disponible") {
                        array_push($ordenDisponibles, $key);
                    }
                    array_push($ordenGeneral, $key);
                    
                }
                //Definir si existe al menos uno disponible
                if (isset($ordenDisponibles[0])) {
                    $registro = $bd->registrarLimpieza($HID, $personalOrdenado[$ordenDisponibles[0]]['ID'], $StrFechaInicio, $StrFechaFin, 'Normal');
                    $NombrePersonal = $personalOrdenado[$ordenDisponibles[0]]['Nombre'] . " " . $personalOrdenado[$ordenDisponibles[0]]['Apellidos'];
                    //Definir el JSON que se enviará a Twilio
                $arreglo = array(
                    'solimp' => $StatusHora,
                    'fechaI' => $StrFechaInicio,
                    'duracion' => $MinutosTotalesLimpieza,
                    'fechaF' => $StrFechaFin,
                    'personalN' => $NombrePersonal
                );
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
                    }
                    //Generador de periodos de texto
                    sort($PeriodosInternos);
                    $StringHorario = "Horario para " .$fechaDia. ": \n";
                    $De = true;
                    foreach ($PeriodosInternos as $num => $periodo) {
                        $PeriodoFecha = date("H:i", $periodo);
                        
                        if ($De == true) {
                            $StringHorario = $StringHorario. "De: ". $PeriodoFecha;
                            $De = false;
                        }
                        else{
                            $StringHorario = $StringHorario. " A ". $PeriodoFecha ."\n";
                            $De = true;
                        }
                    }
                    //Envío de error
                    $StatusHora = "error";
                    $arreglo = array(
                    'solimp' => $StatusHora,
                    'error' => "Parece que todo el personal de limpieza está ocupado a esa hora!
Te recomiendo que reprograme su solicitud en algun punto del siguiente horario \n ".$StringHorario."
Tomando a consideración que debe pedir su limpieza " . $MinutosTotalesLimpieza . " minutos antes de los límites establecidos."
                );
                }
                
            }
            else{
                $StatusHora = "error";
                $arreglo = array(
                'solimp' => $StatusHora,
                'error' => "Su limpieza parece diferir del horario laboral del personal de limpieza"
            );
            }
            
        }
        else {
            $StatusHora = "error";
            $arreglo = array(
                'solimp' => $StatusHora,
                'error' => "Esa habitación no estará ocupada para entonces"
            );
        }
        
    }
    else{
        $arreglo = array(
            'solimp' => $StatusHora
        );
    }
    //Función que ordena arreglos
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
    
    //CONSULTAR BASE DE DATOS
    // $res = $bd->consultarCodigo($codigo);
    // $res2 = $bd->registrarNumero($numero, $HID);
    //CREAR JSON PARA POSTEAR
    
    $JSONNUMERO = json_encode($arreglo);
    print_r($JSONNUMERO);

    
?>