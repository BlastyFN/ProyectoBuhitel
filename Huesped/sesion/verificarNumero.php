<?php 
    if (isset($_POST['numero'])) {
        $Numero = $_POST['numero'];
        echo "Hola, numero recibido ".$Numero;
    }
    else{
        echo "Hola, error numero no recibido";
    }
?>