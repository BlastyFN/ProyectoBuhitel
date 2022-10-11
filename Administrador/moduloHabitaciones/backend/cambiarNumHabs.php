<?php
    session_start();
    include "bd.php";
    if(isset($_POST['antiguoNumHabs']) && isset($_POST['nuevoNumHabs'])){
        $antiguoNumHabs =json_decode($_POST['antiguoNumHabs']);
        $nuevoNumHabs = json_decode( $_POST['nuevoNumHabs']);
        // $pisoID = $_POST['pisoID'];
        $hotel = $_SESSION['sesionPersonal']['Hotel'];
        $bd = new database();
        
        
        for($contPisos = 0; $contPisos < count($nuevoNumHabs); $contPisos++){
            $antiguoNum = ($contPisos+1) * 100 + (int)$antiguoNumHabs[$contPisos];
            $nuevoNum =($contPisos+1) * 100 + (int)$nuevoNumHabs[$contPisos];
            
            $pisoID = $bd-> obtenerPisoID(($contPisos+1),$hotel);
            $tipoHab = $bd->obtenerPrimerTipoHabID($hotel);

            if($nuevoNum > $antiguoNum){
                for($cont = $antiguoNum; $cont <= $nuevoNum; $cont++){
                    
                        $bd->registrarHab($cont,$pisoID,$tipoHab);
                    
                }
                echo "Se han agregado ". ($nuevoNum - $antiguoNum). " habitaciones";
            } else{
                for($cont = $antiguoNum; $cont > $nuevoNum; $cont--){
                    
                        $bd->eliminarHab((string)$cont,$hotel);
                    
                }
                echo "Se han eliminado ". $antiguoNum - $nuevoNum. " habitaciones";
            }

        }


       
    }



?>