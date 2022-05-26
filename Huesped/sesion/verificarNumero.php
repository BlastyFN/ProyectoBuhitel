<?php 
    if (isset($_POST['numero'])) {
        $Numero = $_POST['numero'];
        
        $String = "Hola, numero recibido ".$Numero;
        $resultado['registrado'] = json_encode($String);
        // echo $resultado['registrado'];
        var_dump($resultado['registrado']);
        
    }
    else{
        $String =  "Hola, error numero no recibido";
        $resultado = json_encode($String);
        echo $resultado;
    }
?>