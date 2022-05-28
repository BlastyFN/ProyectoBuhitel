<?php 
    class database{
        private $con;
        function __construct(){
            $this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022');
        }
        //funciones
        public function consultarSesion($Numero, $Hoy){
            $sql = $this->con->prepare("SELECT hotel.Hotel_Nombre, huesped.Huesped_Nombre, huesped.Huesped_Apellidos, habitacion.Habitacion_Nombre FROM habitacionreservada
            INNER JOIN habitacion ON habitacion.Habitacion_ID = HabReservada_Habitacion
            INNER JOIN reservacion ON reservacion.Reservacion_ID = HabReservada_Reservacion
            INNER JOIN huesped ON huesped.Huesped_ID = reservacion.Reservacion_Huesped
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo
            INNER JOIN hotel ON hotel.Hotel_ID = tipohabitacion.TipoHab_Hotel
            WHERE BINARY habitacionreservada.HabReservada_NumWhatsapp = '".$Numero."'
            AND BINARY '".$Hoy."' BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }
        
    }

?>