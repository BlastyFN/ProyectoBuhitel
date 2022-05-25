<?php 
    if (isset($_POST['numero'])) {
        $Numero = $_POST['numero'];
        
        $String = "Hola, numero recibido ".$Numero;
        $registrado = json_encode($String);
        echo $registrado;
    }
    else{
        $String =  "Hola, error numero no recibido";
        $registrado = json_encode($String);
        echo $registrado;
    }
?>