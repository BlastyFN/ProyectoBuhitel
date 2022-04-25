<?php 
    class database{
        private $con;
        function __construct(){
            $this->con = new PDO ('mysql:host = localhost;dbname=buhitel','root','');
        }
        //funciones
        

        public function consultarVehiculo($Hotel, $Hoy, $Habitacion){
            $sql = $this->con->prepare("SELECT Vehiculo_Placas, Vehiculo_Modelo, huesped.Huesped_Nombre, huesped.Huesped_Apellidos, huesped.Huesped_Contacto
            FROM vehiculo
            INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_ID = Vehiculo_Habitacion
            INNER JOIN habitacion ON habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID
            INNER JOIN tipohabitacion ON habitacion.Habitacion_Tipo = tipohabitacion.TipoHab_ID
            INNER JOIN reservacion ON habitacionreservada.HabReservada_Reservacion = reservacion.Reservacion_ID
            INNER JOIN huesped ON huesped.Huesped_ID = reservacion.Reservacion_Huesped
            WHERE BINARY tipohabitacion.TipoHab_Hotel = '".$Hotel."'
            AND BINARY '".$Hoy."' BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut
            AND BINARY habitacion.Habitacion_Nombre = '".$Habitacion."'
            ");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function actualizarEstatus($Placas, $Estatus){
            $sql = $this->con->prepare("UPDATE `vehiculo` SET 
            Vehiculo_Estatus= '".$Estatus."'
             WHERE Vehiculo_Placas = '".$Placas."'");
            $sql->execute();
            return 1;
        }
        
    }

?>