<?php
    session_start();
    include "bd.php";
    if(isset($_POST['antiguoNumHabs']) && isset($_POST['nuevoNumHabs'])){
        $antiguoNumHabs =json_decode($_POST['antiguoNumHabs']);
        $nuevoNumHabs = json_decode( $_POST['nuevoNumHabs']);
        // $pisoID = $_POST['pisoID'];
        $hotel = $_SESSION['sesionPersonal']['Hotel'];
        $bd = new database();
    
        
        for($contPisos = 0; $contPisos < count($antiguoNumHabs); $contPisos++){
            $antiguoNumHabs = ($contPisos+1) * 100 + (int)$antiguoNumHabs;
            $nuevoNumHabs =($contPisos+1) * 100 + (int)$nuevoNumHabs;
            $pisoID = $bd-> obtenerPisoID(($contPisos+1),$hotel);
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