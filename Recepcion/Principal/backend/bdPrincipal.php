<?php 
    class database{
        private $con;
        function __construct(){
            $this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022');
        }
        //funciones
        public function consultaHabitaciones($Hotel){
            $sql = $this->con->prepare("SELECT Habitacion_ID FROM habitacion 
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = Habitacion_Tipo
            WHERE BINARY tipohabitacion.TipoHab_Hotel = '".$Hotel."'
            AND BINARY Habitacion_Estado = '1'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }
        public function consultarReservadas($Hotel, $Hoy){
            $sql = $this->con->prepare("SELECT tipohabitacion.TipoHab_Nombre, tipohabitacion.TipoHab_ID FROM habitacionreservada
            INNER JOIN reservacion ON reservacion.Reservacion_ID = HabReservada_Reservacion
            INNER JOIN habitacion ON habitacion.Habitacion_ID = HabReservada_Habitacion
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo
            WHERE BINARY '".$Hoy."' BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }


        public function consultarCINS($Hotel, $Hoy, $Manana){
            $sql = $this->con->prepare("SELECT HabReservada_ID FROM habitacionreservada
            INNER JOIN reservacion ON reservacion.Reservacion_ID = HabReservada_Reservacion
            WHERE BINARY reservacion.Reservacion_CheckIn BETWEEN '".$Hoy."' AND '".$Manana."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarCOTS($Hotel, $Hoy, $Manana){
            $sql = $this->con->prepare("SELECT HabReservada_ID FROM habitacionreservada
            INNER JOIN reservacion ON reservacion.Reservacion_ID = HabReservada_Reservacion
            WHERE BINARY reservacion.Reservacion_CheckOut BETWEEN '".$Hoy."' AND '".$Manana."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarHabsTipo($Tipo){
            $sql = $this->con->prepare("SELECT Habitacion_ID FROM habitacion
            WHERE BINARY Habitacion_Tipo = '".$Tipo."'
            AND BINARY Habitacion_Estado = '1'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarHabsOcupadas($Tipo, $Hoy){
            $sql = $this->con->prepare("SELECT HabReservada_ID FROM habitacionreservada 
            INNER JOIN habitacion ON habitacion.Habitacion_ID = HabReservada_Habitacion
            INNER JOIN reservacion ON reservacion.Reservacion_ID = HabReservada_Reservacion
            WHERE BINARY '".$Hoy."' BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut
            AND BINARY habitacion.Habitacion_Tipo = '".$Tipo."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarTipos($Hotel){
            $sql = $this->con->prepare("SELECT TipoHab_ID, TipoHab_Nombre FROM tipohabitacion 
            WHERE TipoHab_Hotel = '".$Hotel."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }
    }

?>