<?php 
    class database{
        private $con;
        function __construct(){
            $this->con = new PDO ('mysql:host = localhost;dbname=buhitel','root','');
        }
        //funciones
        public function consultaTipos($Hotel){
            $sql = $this->con->prepare("SELECT TipoHab_ID, TipoHab_Nombre, TipoHab_Precio FROM tipohabitacion WHERE BINARY TipoHab_Hotel = '".$Hotel."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }
    }

?>