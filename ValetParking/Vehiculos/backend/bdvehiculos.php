<?php 
    class database{
        private $con;
        function __construct(){
            $this->con = new PDO ('mysql:host = localhost;dbname=buhitel','root','');
        }
        //funciones
        public function consultarHuesped($Hotel, $Habitacion, $Hoy){
            $NumManana = time($Hoy)+86400;
            $Manana = date("c", $NumManana);
            $sql = $this->con->prepare("SELECT Reservacion_Huesped, habitacionreservada.HabReservada_ID
            FROM reservacion 
            INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_Reservacion = Reservacion_ID
            INNER JOIN habitacion ON habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo
            WHERE BINARY habitacion.Habitacion_Nombre = '".$Habitacion."'
            AND BINARY tipohabitacion.TipoHab_Hotel = '".$Hotel."'
            AND BINARY '".$Hoy."' BETWEEN `Reservacion_CheckIn` AND `Reservacion_CheckOut`");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function registrarVehiculo($Placas, $Huesped, $Habitacion, $Modelo, $Color, $Lugar, $Notas){
            $sql = $this->con->prepare("SELECT * FROM vehiculo WHERE BINARY Vehiculo_Habitacion = '".$Habitacion."'");
            $sql->execute();
            $res = $sql->fetchall();
            if (count($res) > 0)
            {
                $sql = $this->con->prepare("UPDATE `vehiculo` SET 
            Vehiculo_Placas= '".$Placas."', 
            Vehiculo_Modelo= '".$Modelo."', 
            Vehiculo_Color= '".$Color."', 
            Vehiculo_LugarEstacionamiento= '".$Lugar."',
            Vehiculo_Notas= '".$Notas."'
             WHERE Vehiculo_Habitacion = '".$Habitacion."'");
            $sql->execute();
            }
            else{
                $sql = $this->con->prepare("INSERT INTO vehiculo (Vehiculo_Placas, Vehiculo_Huesped, Vehiculo_Habitacion, Vehiculo_Modelo, Vehiculo_Color, Vehiculo_LugarEstacionamiento, Vehiculo_Notas) VALUES ('".$Placas."','".$Huesped."','".$Habitacion."','".$Modelo."','".$Color."','".$Lugar."','".$Notas."')");
                $sql->execute();
            }
            
        }

        public function consultarVehiculos($Hotel, $Hoy){
            $sql = $this->con->prepare("SELECT Vehiculo_Placas, Vehiculo_Modelo, Vehiculo_Color, Vehiculo_LugarEstacionamiento, Vehiculo_Notas, habitacion.Habitacion_Nombre, huesped.Huesped_Nombre
            FROM vehiculo
            INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_ID = Vehiculo_Habitacion
            INNER JOIN habitacion ON habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID
            INNER JOIN tipohabitacion ON habitacion.Habitacion_Tipo = tipohabitacion.TipoHab_ID
            INNER JOIN reservacion ON habitacionreservada.HabReservada_Reservacion = reservacion.Reservacion_ID
            INNER JOIN huesped ON huesped.Huesped_ID = reservacion.Reservacion_Huesped
            WHERE BINARY tipohabitacion.TipoHab_Hotel = '".$Hotel."'
            AND BINARY '".$Hoy."' BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut
            ");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }
        
    }

?>