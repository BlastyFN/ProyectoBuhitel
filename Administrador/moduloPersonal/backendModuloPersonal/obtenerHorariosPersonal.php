<?php
    include "bd.php";
    session_start();
    if(isset($_POST['personalID'])){

        $personal_id = $_POST['personalID'];
        $bd = new database();
        $res = $bd-> obtenerHorarioPersonal($personal_id);
        echo json_encode($res);

    }
?>