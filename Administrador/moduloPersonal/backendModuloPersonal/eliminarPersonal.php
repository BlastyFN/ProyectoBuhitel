<?php
    include "bd.php";
    session_start();
    if(isset($_POST['personalID'])){

        $hotel = $_SESSION['sesionPersonal']['Hotel'];
        $personal_id = $_POST['personalID'];
        $bd = new database();
        $res = $bd-> eliminarPersonal($hotel,$personal_id);
        echo json_encode($res);

    }
?>