<?php
    include "bd.php";
    if(isset($_POST['antiguoNumHabs']) && isset($_POST['nuevoNumHabs']) &&  isset($_POST['pisoID'])){
        $antiguoNumHabs = $_POST['antiguoNumHabs'];
        $nuevoNumHabs = $_POST['nuevoNumHabs'];
        $pisoID = $_POST['pisoID'];
            
        $hotel = 1;
        $bd = new database();
        $piso = $bd-> obtenerPiso($pisoID,$hotel);
        $antiguoNumHabs = $piso * 100 + $antiguoNumHabs;
        $nuevoNumHabs =$piso * 100 + $nuevoNumHabs;
        
        if($nuevoNumHabs > $antiguoNumHabs){
            for($cont = $antiguoNumHabs; $cont <= $nuevoNumHabs; $cont++){
                if($cont != ($piso*100)){
			        $bd->registrarHab($cont,$pisoID,1);
                }
		    }
            echo "Se han agregado ". ($nuevoNumHabs - $antiguoNumHabs). " habitaciones";
        } else{
            for($cont = $antiguoNumHabs; $cont >= $nuevoNumHabs; $cont--){
			    if($piso-$cont!=0){
                    $bd->eliminarHab($cont);
                }
            }
            echo "Se han eliminado ". ($antiguoNumHabs - $nuevoNumHabs). " habitaciones";
        }
       
    }



?>