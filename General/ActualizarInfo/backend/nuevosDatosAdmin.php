<?php 
    session_start();
    include "bdGeneral.php";
    if (isset($_POST['Nombre']) && isset($_POST['APaterno']) && isset($_POST['AMaterno']) && isset($_POST['Correo']) && isset($_POST['Telefono'])) {
        $bd = new database();
        $Usuario = $_SESSION['sesionPersonal']['ID'];
        $HotelID = $_SESSION['sesionPersonal']['Hotel'];
        $Nombre = $_POST['Nombre'];
        $ApellidoP = $_POST['APaterno'];
        $ApellidoM = $_POST['AMaterno'];
        $Correo = $_POST['Correo'];
        $Telefono = $_POST['Telefono'];
        $Hotel = $_POST['Hotel'];
        $NH = $bd->actualizarHotel($Hotel, $HotelID);
        $res = $bd->consultaInfoPersonal($Usuario);
        if (isset($res[0])) {
            $datos = json_encode($res[0]);
            if ($res[0]['Personal_Correo'] == $Correo) {
                $res = $bd->actualizarSCorreo($Nombre, $ApellidoP, $ApellidoM, $Telefono, $Usuario);
                echo "Actualización de datos completada";
            }
            else{
                $StatCorreo = $bd->consultarCorreo($Correo);
                if ($StatCorreo == false) {
                    $res = $bd->actualizarCCorreo($Nombre, $ApellidoP, $ApellidoM, $Correo, $Telefono, $Usuario);
                    echo "Actualización de datos completada";
                }
                else{
                    echo "Error, correo ya registrado";
                }
                
            }
        }
        
    }
    else{
        echo "0";
    }
    
?>