<?php 
    class database{
        private $con;
        function __construct(){
            $this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022');
        }
        //funciones
        public function consultaInfoPersonal($Usuario){
            $sql = $this->con->prepare("SELECT Personal_Nombre, Personal_APaterno, Personal_AMaterno, Personal_Correo, Personal_Telefono FROM personal
            WHERE BINARY Personal_ID = '".$Usuario."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function actualizarCCorreo($Nombre, $APatenro, $AMaterno, $Correo, $Telefono, $Usuario){
            $sql = $this->con->prepare("UPDATE personal 
            SET Personal_Nombre='".$Nombre."', 
            Personal_APaterno='".$APatenro."', Personal_AMaterno='".$AMaterno."', 
            Personal_Telefono='".$Telefono."', Personal_Correo='".$Correo."'
            WHERE BINARY Personal_ID='".$Usuario."'");
            $sql->execute();
            return true;
        }

        public function actualizarSCorreo($Nombre, $APatenro, $AMaterno, $Telefono, $Usuario){
            $sql = $this->con->prepare("UPDATE personal 
            SET Personal_Nombre='".$Nombre."', 
            Personal_APaterno='".$APatenro."', Personal_AMaterno='".$AMaterno."', 
            Personal_Telefono='".$Telefono."'
            WHERE BINARY Personal_ID='".$Usuario."'");
            $sql->execute();
            return true;
        }

        public function cambiarClave($Usuario, $Clave){
            $sql = $this->con->prepare("UPDATE personal SET Personal_Contrasena= '".$Clave."'
            WHERE BINARY Personal_ID = '".$Usuario."'");
            $sql->execute();
            $Estatus = "Clave cambiada con exito";
            return $Estatus;
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
        

        
    }

?>