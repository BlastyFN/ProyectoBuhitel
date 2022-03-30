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

        public function registrarReservacion($Nombre, $Apellidos, $Contacto, $CIN, $COUT){
            $sql = $this->con->prepare("INSERT INTO huesped (Huesped_Nombre, Huesped_Apellidos, Huesped_Contacto) VALUES ('".$Nombre."','".$Apellidos."','".$Contacto."')");
            $sql->execute();
            $sql = $this->con->prepare("SELECT Huesped_ID FROM huesped WHERE BINARY Huesped_Nombre = '".$Nombre."' and BINARY Huesped_Contacto = '".$Contacto."'");
            $sql->execute();
            $HID;
            $res = $sql->fetchall();
            if (count($res) > 0)
            {
                foreach ($res as $dato)
                $HID = $dato['Huesped_ID'];
            }
            $sql = $this->con->prepare("INSERT INTO reservacion(Reservacion_Huesped, Reservacion_CheckIn, Reservacion_CheckOut) VALUES ('".$HID."','".$CIN."','".$COUT."')");
            $sql->execute();

            $sql = $this->con->prepare("SELECT Reservacion_ID FROM reservacion WHERE BINARY Reservacion_Huesped = '".$HID."'");
            $sql->execute();
            $RID;
            $res2 = $sql->fetchall();
            if (count($res2) > 0)
            {
                foreach ($res2 as $dato2)
                $RID = $dato2['Reservacion_ID'];

            }
            else {
                $RID = 'No se encontro reservacion';
            }
            return $RID;
        }

        public function reservarHab($Reservacion, $Habitacion){
            $Codigo = '';
            $caracteres = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
            $numCar = strlen($caracteres);
            for ($i=0; $i < 6; $i++) { 
                $caracterRandom = $caracteres[mt_rand(0, $numCar-1)];
                $Codigo .= $caracterRandom;
            }
            $sql = $this->con->prepare("INSERT INTO habitacionreservada (HabReservada_CodigoWhatsapp, HabReservada_Reservacion, HabReservada_Habitacion	) VALUES ('".$Codigo."','".$Reservacion."','".$Habitacion."')");
            $sql->execute();
            return '1';
        }

        public function consultarDisponibilidad($Habitacion, $Fecha){
            $sql = $this->con->prepare("SELECT habitacion_nombre, reservacion.Reservacion_CheckIn, reservacion.Reservacion_CheckOut FROM habitacionreservada INNER JOIN habitacion ON HabReservada_Habitacion = habitacion.Habitacion_ID INNER JOIN reservacion ON reservacion.Reservacion_ID = HabReservada_Reservacion WHERE habitacion.Habitacion_ID = '".$Habitacion."' AND '".$Fecha."' BETWEEN Reservacion_CheckIn AND Reservacion_CheckOut");
            $sql->execute();
            $res = $sql->fetchall();
            $estatus = "true";
            if (isset($res[0])) {
                $estatus = "false";
            }
            return $estatus;
        }

        public function consultaHabRes($Hotel, $Fecha){
            $sql = $this->con->prepare("SELECT huesped.Huesped_Nombre, huesped.Huesped_Apellidos, huesped.Huesped_Contacto, habitacionreservada.HabReservada_CodigoWhatsapp, habitacion.Habitacion_Nombre, tipohabitacion.TipoHab_Nombre,Reservacion_ID, Reservacion_CheckIn, Reservacion_CheckOut FROM reservacion INNER JOIN huesped ON Reservacion_Huesped = huesped.Huesped_ID INNER JOIN habitacionreservada ON Reservacion_ID = habitacionreservada.HabReservada_Reservacion INNER JOIN habitacion ON habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID INNER JOIN tipohabitacion ON habitacion.Habitacion_Tipo = tipohabitacion.TipoHab_ID WHERE tipohabitacion.TipoHab_Hotel = '".$Hotel."' AND Reservacion_CheckOut > '".$Fecha."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }
    }

?>