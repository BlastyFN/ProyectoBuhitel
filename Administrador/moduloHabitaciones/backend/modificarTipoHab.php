<?php
        include "bd.php";
        if(isset($_POST['ID']) && isset($_POST['nombre']) &&  isset($_POST['precio']) && isset($_POST['numCamas']) 
        && isset($_POST['limpNormal']) && isset($_POST['limpProf'])){
            $ID = $_POST['ID'];
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $numCamas = $_POST['numCamas'];
            $limpNormal = $_POST['limpNormal'];
            $limpProf = $_POST['limpProf'];
            
            $hotel = 1;
            $bd = new database();
            $res = $bd-> modificarTipoHab($hotel,$ID,$nombre,$precio,$numCamas,$limpNormal,$limpProf);
            echo $res;
        }



?>