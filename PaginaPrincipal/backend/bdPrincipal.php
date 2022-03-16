<?php 
    class database{
        private $con;
        function __construct()
        {
            $this->con = new PDO ('mysql:host = localhost;dbname=buhitel','root','');
        }   
        public function registroPrincipal($HotelNombre, $Correo, $PersonalNombre, $PersonalAPaterno, $PersonalAMaterno, $PersonalTelefono, $PersonalClave){
            /* SENTENCIA DE REGESITRAR HOTEL*/
            $sql = $this->con->prepare("INSERT INTO hotel (Hotel_Nombre, Hotel_Correo) VALUES ('".$HotelNombre."','".$Correo."')");
            $sql->execute();
            /* SENTENCIA DE OBTENER EL ID DEL HOTEL */
            $sql = $this->con->prepare("SELECT Hotel_ID FROM hotel WHERE BINARY Hotel_CORREO = '".$Correo."'");
            $sql->execute();
            $HID;
            $res = $sql->fetchall();
            if (count($res) > 0)
            {
                foreach ($res as $dato)
                $HID = $dato['Hotel_ID'];
            }

            /* SENTENCIA DE REGISTRAR USUARIO */
            $Tipo = "Administrador";
            $NuevaClave = md5($PersonalClave);
            $sql = $this->con->prepare("INSERT INTO personal (Personal_Hotel, Personal_Nombre, Personal_APaterno, Personal_AMaterno, Personal_Tipo, Personal_Telefono, Personal_Correo, Personal_Contrasena) VALUES ('".$HID."','".$PersonalNombre."','".$PersonalAPaterno."','".$PersonalAMaterno."','".$Tipo."','".$PersonalTelefono."','".$Correo."','".$NuevaClave."')");
            $sql->execute();
            return 2;
        }

        public function consultarCorreo($Correo){
            $sql = $this->con->prepare("SELECT Personal_Correo FROM personal WHERE BINARY Personal_Correo = '".$Correo."'");
            $sql->execute();
            $res = $sql->fetchall();
            $status = false;
            if (count($res) > 0)
            {
                $status = true;
            }
            return $status;
        }

        public function consultarSesion($Correo, $Clave){
            $sql = $this->con->prepare("SELECT Personal_ID, Personal_Nombre, Personal_Tipo, Personal_Hotel FROM personal WHERE BINARY Personal_Correo = '".$Correo."'and BINARY Personal_Contrasena = '".$Clave."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function renovarClave($Correo, $Clave){
            $sql = $this->con->prepare("UPDATE personal SET Personal_Contrasena = '$Clave' WHERE BINARY Personal_Correo = '".$Correo."'");
            $sql->execute();
            return 2;
        }

    }
    


?>