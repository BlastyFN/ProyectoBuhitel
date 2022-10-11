<?php
    session_start();
    include "bd.php";
    if(isset($_POST['antiguoNumHabs']) && isset($_POST['nuevoNumHabs']) &&  isset($_POST['pisoID'])){
        $antiguoNumHabs = $_POST['antiguoNumHabs'];
        $nuevoNumHabs = $_POST['nuevoNumHabs'];
        $pisoID = $_POST['pisoID'];
        $hotel = $_SESSION['sesionPersonal']['Hotel'];
        $bd = new database();
        $piso = $bd-> obtenerPiso($pisoID,$hotel);
        $antiguoNumHabs = $piso * 100 + (int)$antiguoNumHabs;
        $nuevoNumHabs =$piso * 100 + (int)$nuevoNumHabs;
        
        $tipoHab = $bd->obtenerPrimerTipoHabID($hotel);
        if($nuevoNumHabs > $antiguoNumHabs){
            for($cont = $antiguoNumHabs; $cont <= $nuevoNumHabs; $cont++){
                if($cont != ($piso*100)){
			        $bd->registrarHab($cont,$pisoID,$tipoHab);
                }
		    }
            echo "Se han agregado ". ($nuevoNumHabs - $antiguoNumHabs). " habitaciones";
        } else{
            for($cont = $antiguoNumHabs; $cont > $nuevoNumHabs; $cont--){
			    if($piso-$cont!=0){
                    $bd->eliminarHab((string)$cont,$hotel);
                }
            }
            echo "Se han eliminado ". ($antiguoNumHabs - $nuevoNumHabs). " habitaciones";
        }
       
    }



?>