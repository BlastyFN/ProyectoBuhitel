<?php 
    if (isset($_POST['numero'])) {
        $Numero = $_POST['numero'];
        $String = "Hola, numero recibido ".$Numero;
        $resultado = ["registrado"=>$String];
        print_r(json_encode($resultado));
        
    }
    else{
        $String =  "Hola, error numero no recibido";
        $resultado = json_encode($String);
        echo $resultado;
    }
?>