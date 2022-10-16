<?php
    include "bd.php";
    session_start();
    if(isset($_POST['tipo'])){

        $hotel = $_SESSION['sesionPersonal']['Hotel'];
        
        $tipo = $_POST['tipo'];
        $bd = new database();
        $res = $bd-> obtenerListaPersonal($hotel,$tipo);
        echo json_encode($res);

    }
?>