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
            $sql = $this->con->prepare("SELECT HabReservada_ID FROM habitacionreservada
            INNER JOIN reservacion ON reservacion.Reservacion_ID = HabReservada_Reservacion
            WHERE BINARY '".$Hoy."' BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

    }

?>