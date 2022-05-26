<?php 
    if (isset($_POST['numero'])) {
        $Numero = $_POST['numero'];
        
        $String = "Hola, numero recibido ".$Numero;
        $resultado['registrado'] = json_encode($String);
        echo $resultado;
        
    }
    else{
        $String =  "Hola, error numero no recibido";
        $resultado['registrado'] = json_encode($String);
        echo $resultado;
    }
?>