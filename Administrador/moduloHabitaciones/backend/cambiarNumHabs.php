<?php
    session_start();
    include "bd.php";
    if(isset($_POST['antiguoNumHabs']) && isset($_POST['nuevoNumHabs'])){
        $antiguoNumHabs = $_POST['antiguoNumHabs'];
        $nuevoNumHabs = $_POST['nuevoNumHabs'];
        // $pisoID = $_POST['pisoID'];
        $hotel = $_SESSION['sesionPersonal']['Hotel'];
        $bd = new database();
        
        $antiguoNumHabs = $piso * 100 + (int)$antiguoNumHabs;
        $nuevoNumHabs =$piso * 100 + (int)$nuevoNumHabs;
        
        for($contPisos = 0; $contPisos < count($antiguoNumHabs); $contPisos++){
            $pisoID = $bd-> obtenerPisoID($contPisos,$hotel);
            $tipoHab = $bd->obtenerPrimerTipoHabID($hotel);
            if($nuevoNumHabs > $antiguoNumHabs){
                for($cont = $antiguoNumHabs; $cont <= $nuevoNumHabs; $cont++){
                    
                        $bd->registrarHab($cont,$pisoID,$tipoHab);
                    
                }
                echo "Se han agregado ". ($nuevoNumHabs - $antiguoNumHabs). " habitaciones";
            } else{
                for($cont = $antiguoNumHabs; $cont > $nuevoNumHabs; $cont--){
                    
                        $bd->eliminarHab((string)$cont,$hotel);
                    
                }
                echo "Se han eliminado ". ($antiguoNumHabs - $nuevoNumHabs). " habitaciones";
            }

        }


       
    }



?>