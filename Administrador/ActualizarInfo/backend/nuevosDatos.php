<?php 
    session_start();
    include "bdGeneral.php";
    if (isset($_POST['Pregunta'])) {
        $bd = new database();
        $Hotel = $_SESSION['sesionPersonal']['Hotel'];
        $Pregunta = $_POST['Pregunta'];
        $res = $bd->actualizarPregunta($Hotel, $Pregunta);
        echo $res;
    }
    else{
        echo "0";
    }
    
?>