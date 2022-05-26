<?php 
    if (isset($_POST['numero'])) {
        $Numero = $_POST['numero'];
        $resultado = [];
        $String = "Hola, numero recibido ".$Numero;
        $reg['registrado'] = $String;

        array_push($resultado, $reg);
        $nuevoResultado = json_encode($resultado);
        echo $nuevoResultado[0];
        // echo $resultado;
        // var_dump($resultado);
        
    }
    else{
        $String =  "Hola, error numero no recibido";
        $resultado = json_encode($String);
        echo $resultado;
    }
?>