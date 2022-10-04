<?php 
    session_start();
    include "bdGeneral.php";
    if (isset($_POST['Pregunta'])) {
        $bd = new database();
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $Pregunta = $_POST['Pregunta'];

        $res1 = $bd->consultarPregunta($Hotel);
        if (isset($res1[0])) {
            $res = $bd->actualizarPregunta($Hotel, $Pregunta);
            echo $res;
        }
        else{
            $res = $bd->insertarPregunta($Hotel, $Pregunta);
            echo $res;
        }
    
    }
    else{
        echo "0";
    }
    
?>