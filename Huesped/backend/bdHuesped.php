<?php 
    class database{
        private $con;
        function __construct(){
            $this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022');
        }
        //funciones
        public function consultarSesion($Numero, $Hoy){
            $sql = $this->con->prepare("SELECT hotel.Hotel_Nombre, huesped.Huesped_Nombre, huesped.Huesped_Apellidos, habitacion.Habitacion_Nombre, habitacion.Habitacion_ID FROM habitacionreservada
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

        public function consultarCodigo($codigo){
            $sql = $this->con->prepare("SELECT habitacion.Habitacion_Nombre, hotel.Hotel_Nombre, huesped.Huesped_Nombre, huesped.Huesped_Apellidos, HabReservada_ID FROM habitacionreservada
            INNER JOIN habitacion ON habitacion.Habitacion_ID = habitacionreservada.HabReservada_Habitacion
            INNER JOIN reservacion ON reservacion.Reservacion_ID = habitacionreservada.HabReservada_Reservacion
            INNER JOIN huesped ON huesped.Huesped_ID = reservacion.Reservacion_Huesped
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo
            INNER JOIN hotel ON hotel.Hotel_ID = tipohabitacion.TipoHab_Hotel
            WHERE HabReservada_CodigoWhatsapp = '".$codigo."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }
        
        public function registrarNumero($Numero, $Habitacion){
            $sql = $this->con->prepare("UPDATE habitacionreservada SET HabReservada_NumWhatsapp = '".$Numero."'
            WHERE BINARY HabReservada_ID = '".$Habitacion."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }
        public function consultarVehiculo($Hoy, $Habitacion){
            $sql = $this->con->prepare("SELECT Vehiculo_Placas, Vehiculo_Modelo, huesped.Huesped_Nombre, huesped.Huesped_Apellidos, huesped.Huesped_Contacto
            FROM vehiculo
            INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_ID = Vehiculo_Habitacion
            INNER JOIN habitacion ON habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID
            INNER JOIN tipohabitacion ON habitacion.Habitacion_Tipo = tipohabitacion.TipoHab_ID
            INNER JOIN reservacion ON habitacionreservada.HabReservada_Reservacion = reservacion.Reservacion_ID
            INNER JOIN huesped ON huesped.Huesped_ID = reservacion.Reservacion_Huesped
            WHERE BINARY '".$Hoy."' BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut
            AND BINARY habitacion.Habitacion_ID = '".$Habitacion."'
            ");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function solicitudVehiculo($Placas, $Estatus){
            $sql = $this->con->prepare("UPDATE `vehiculo` SET 
            Vehiculo_Estatus= '".$Estatus."'
             WHERE Vehiculo_Placas = '".$Placas."'");
            $sql->execute();
            return true;
        }
    }

?>