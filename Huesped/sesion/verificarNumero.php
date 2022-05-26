<?php 
    if (isset($_POST['numero'])) {
        $Numero = $_POST['numero'];
        $resultado = [];
        $String = "Hola, numero recibido ".$Numero;
        $reg['registrado'] = json_encode($String);
        array_push($resultado, $reg);
        // echo $resultado['registrado'];
        var_dump($resultado);
        
    }
    else{
        $String =  "Hola, error numero no recibido";
        $resultado = json_encode($String);
        echo $resultado;
    }
?>