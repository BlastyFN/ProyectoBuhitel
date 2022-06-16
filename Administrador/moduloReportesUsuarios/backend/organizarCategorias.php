<?php
include "bd.php";
session_start();
if(isset($_POST['listaNombresCats'])){
    $res = "";
    $listaCats = json_decode($_POST['listaNombresCats']);
	$hotel =  46;//$_SESSION['sesionPersonal']['Hotel'];
	$bd = new database();
    // foreach ($listaCats as $categoria) {
    //     bd->reasignarCategoria()
    // }
    for($prioridad = 0; $prioridad < count($listaCats); $prioridad++){
        $res .= $prioridad + 1;
        $res .= $listaCats[$prioridad];
        $res .= "  " . $bd->reasignarCategoria($hotel,$prioridad+1,$listaCats[$prioridad]);
    }
	
	echo $res;
    
    
}
?>