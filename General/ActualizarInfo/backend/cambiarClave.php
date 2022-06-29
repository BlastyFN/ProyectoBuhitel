<?php 
    session_start();
    include "bdGeneral.php";
    if (isset($_POST['Clave'])) {
        $bd = new database();
        $Usuario = $_SESSION['sesionPersonal']['ID'];
        $Clave = $_POST['Clave'];
        $NuevaClave = md5($Clave);
        $res = $bd->cambiarClave($Usuario, $NuevaClave);
        echo $res;
    }
    else{
        echo "0";
    }
    
?>