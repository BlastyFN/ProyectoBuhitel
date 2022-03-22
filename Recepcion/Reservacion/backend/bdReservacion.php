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
        public function consultaTiposEnHotel($Tipo, $Hotel){
            $sql = $this->con->prepare("SELECT TipoHab_ID FROM tipohabitacion WHERE BINARY TipoHab_ID = '".$Tipo."' and BINARY TipoHab_Hotel = '".$Hotel."'");
            $sql->execute();
            $res = $sql->fetchall();
            $ex = false;
            if (isset($res[0])) {
                $ex = true;
            }
            return $ex;
        }
        public function consultaHabitaciones($Tipo, $Estado){

            $sql = $this->con->prepare("SELECT Habitacion_ID, Habitacion_Nombre FROM habitacion WHERE BINARY Habitacion_Tipo = '".$Tipo."' and BINARY Habitacion_Estado = '".$Estado."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }
    }

?>