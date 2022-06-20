<?php 
    class database{
        private $con;
        function __construct(){
            $this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022');
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
            $sql = $this->con->prepare("SELECT huesped.Huesped_Nombre, huesped.Huesped_Apellidos, huesped.Huesped_Contacto, habitacionreservada.HabReservada_CodigoWhatsapp, habitacionreservada.HabReservada_ID, habitacion.Habitacion_Nombre, tipohabitacion.TipoHab_Nombre,Reservacion_ID, Reservacion_CheckIn, Reservacion_CheckOut FROM reservacion INNER JOIN huesped ON Reservacion_Huesped = huesped.Huesped_ID INNER JOIN habitacionreservada ON Reservacion_ID = habitacionreservada.HabReservada_Reservacion INNER JOIN habitacion ON habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID INNER JOIN tipohabitacion ON habitacion.Habitacion_Tipo = tipohabitacion.TipoHab_ID WHERE tipohabitacion.TipoHab_Hotel = '".$Hotel."' AND Reservacion_CheckOut > '".$Fecha."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function cancelarHabRes($Hotel, $HabRes){
            $sql = $this->con->prepare("DELETE h FROM habitacionreservada h 
            INNER JOIN habitacion a ON h.HabReservada_Habitacion = a.Habitacion_ID 
            INNER JOIN tipohabitacion t ON t.TipoHab_Hotel = '".$Hotel."' 
            WHERE BINARY h.HabReservada_ID = '".$HabRes."'");
            $sql->execute();
            return 1;
        }

        public function consultarReservacion($Hotel, $Reservacion){
            $sql = $this->con->prepare("SELECT Reservacion_Huesped, Reservacion_CheckIn, Reservacion_CheckOut, huesped.Huesped_Nombre, huesped.Huesped_Apellidos, huesped.Huesped_Contacto
            FROM reservacion 
            INNER JOIN huesped ON huesped.Huesped_ID = Reservacion_Huesped 
            INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_Reservacion = Reservacion_ID
            INNER JOIN habitacion ON habitacion.Habitacion_ID = habitacionreservada.HabReservada_Habitacion
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo
            WHERE Reservacion_ID = '".$Reservacion."'
            AND BINARY tipohabitacion.TipoHab_Hotel = '".$Hotel."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function actualizarHuesped($Nombre, $Apellidos, $Contacto, $Huesped){
            //
            $sql = $this->con->prepare("UPDATE `huesped` SET 
            Huesped_Nombre= '".$Nombre."', 
            Huesped_Apellidos= '".$Apellidos."', 
            Huesped_Contacto= '".$Contacto."'
             WHERE Huesped_ID = '".$Huesped."'");
            $sql->execute();
            return 'Exito';
        }

        public function consultarReservadas($Hotel, $Reservacion){
            $sql = $this->con->prepare("SELECT habitacion.Habitacion_Nombre, habitacion.Habitacion_Tipo, habitacion.Habitacion_ID, tipohabitacion.TipoHab_Nombre
            FROM habitacionreservada
            INNER JOIN habitacion ON habitacion.Habitacion_ID = HabReservada_Habitacion
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = habitacion.Habitacion_Tipo
            WHERE HabReservada_Reservacion = '".$Reservacion."' 
            AND BINARY tipohabitacion.TipoHab_Hotel = '".$Hotel."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function actualizarFechas($Reservacion, $CIN, $COUT){
            //
            $sql = $this->con->prepare("UPDATE `reservacion` SET 
            Reservacion_CheckIn = '".$CIN."', 
            Reservacion_CheckOut= '".$COUT."'
             WHERE Reservacion_ID = '".$Reservacion."'");
            $sql->execute();
            return 'Exito';
        }

        public function borrarHabitaciones($Reservacion){
            $sql = $this->con->prepare("DELETE FROM `habitacionreservada` WHERE `HabReservada_Reservacion` = '".$Reservacion."'");
            $sql->execute();
            return 'Exito';
        }
        public function eliminarCargos($Reservacion){
            $sql = $this->con->prepare("DELETE FROM `cargo` WHERE `Cargo_Reservacion` = '".$Reservacion."'");
            $sql->execute();
            return 'Exito';
        }
        public function agregarCargo($Reservacion, $Concepto, $Monto){
            $sql = $this->con->prepare("INSERT INTO cargo(Cargo_Reservacion, Cargo_Concepto, Cargo_Monto) 
            VALUES ('".$Reservacion."','".$Concepto."','".$Monto."')");
            $sql->execute();
            return 'Exito';
        }

        public function consultarCargos($Reservacion){
            $sql = $this->con->prepare("SELECT Cargo_Concepto, Cargo_Monto FROM cargo WHERE Cargo_Reservacion = '".$Reservacion."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarCheckout($Reservacion){
            $sql = $this->con->prepare("SELECT Reservacion_CheckOut FROM reservacion WHERE BINARY Reservacion_ID = '".$Reservacion."'");
            $sql->execute();
            $res = $sql->fetchall();
            $COT = $res[0]['Reservacion_CheckOut'];
            return $COT;
        }

        public function ConsultarTiempoLimpieza($Habitacion){
            $sql = $this->con->prepare("SELECT tipohabitacion.TipoHab_TiempoLimpProfunda FROM habitacion 
            INNER JOIN tipohabitacion ON tipohabitacion.TipoHab_ID = Habitacion_Tipo
            WHERE BINARY Habitacion_ID = '".$Habitacion."'");
            $sql->execute();
            $res = $sql->fetchall();
            $COT = $res[0]['TipoHab_TiempoLimpProfunda'];
            return $COT;
        }

        public function consultarPersonal($HInicio, $HFin, $Hotel){
            $sql = $this->con->prepare("SELECT Personal_Nombre, Personal_APaterno, Personal_AMaterno, Personal_ID, infousuariolimpieza.InfoLimpieza_InicioDescanso, infousuariolimpieza.InfoLimpieza_FinDescanso FROM personal
            INNER JOIN infousuariolimpieza ON infousuariolimpieza.InfoLimpieza_Personal = Personal_ID
            WHERE BINARY '".$HInicio."' BETWEEN infousuariolimpieza.InfoLimpieza_InicioJornada AND infousuariolimpieza.InfoLimpieza_FinJornada
            AND BINARY '".$HFin."' BETWEEN infousuariolimpieza.InfoLimpieza_InicioJornada AND infousuariolimpieza.InfoLimpieza_FinJornada
            AND BINARY infousuariolimpieza.InfoLimpieza_InicioDescanso NOT BETWEEN '".$HInicio."' AND '".$HFin."'
            AND BINARY infousuariolimpieza.InfoLimpieza_FinDescanso NOT BETWEEN '".$HInicio."' AND '".$HFin."'
            AND BINARY '".$HInicio."' NOT BETWEEN infousuariolimpieza.InfoLimpieza_InicioDescanso AND infousuariolimpieza.InfoLimpieza_FinDescanso
            AND BINARY '".$HFin."' NOT BETWEEN infousuariolimpieza.InfoLimpieza_InicioDescanso AND infousuariolimpieza.InfoLimpieza_FinDescanso
            AND BINARY Personal_Hotel = '".$Hotel."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarLimpiezasPersonal($Personal, $Dia, $Hotel){

            $sql = $this->con->prepare("SELECT Limpieza_HoraInicio, Limpieza_HoraFin FROM limpieza
            INNER JOIN personal ON personal.Personal_ID = Limpieza_Usuario
            INNER JOIN infousuariolimpieza ON infousuariolimpieza.InfoLimpieza_Personal = personal.Personal_ID
            WHERE BINARY Limpieza_HoraInicio BETWEEN '".$Dia." 00:00' AND '".$Dia." 23:59'
            AND BINARY personal.Personal_ID = '".$Personal."'
            AND BINARY personal.Personal_Hotel = '".$Hotel."';");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarDisponbilidad($Personal, $Inicio, $Final){

            $sql = $this->con->prepare("SELECT Limpieza_ID, habitacion.Habitacion_Nombre FROM limpieza
            INNER JOIN habitacion ON habitacion.Habitacion_ID = Limpieza_Habitacion
            WHERE BINARY Limpieza_Usuario = '".$Personal."' 
            AND BINARY 
            ('".$Inicio."' BETWEEN Limpieza_HoraInicio AND Limpieza_HoraFin
             OR '".$Final."' BETWEEN Limpieza_HoraInicio AND Limpieza_HoraFin
             OR Limpieza_HoraInicio BETWEEN '".$Inicio."' AND '".$Final."'
             OR Limpieza_HoraFin BETWEEN '".$Inicio."' AND '".$Final."'
            );");
            $sql->execute();
            $res = $sql->fetchall();
            $disponibilidad = "Disponible";
            if (isset($res[0])) {
                $disponibilidad = "Ocupado";
            }
            return $disponibilidad;
        }

        public function registrarLimpieza($Habitacion, $Usuario, $Inicio, $Fin, $Tipo){
            $sql = $this->con->prepare("INSERT INTO limpieza(Limpieza_Habitacion, Limpieza_Usuario, Limpieza_HoraInicio, Limpieza_HoraFin, Limpieza_Tipo) 
            VALUES ('".$Habitacion."','".$Usuario."','".$Inicio."','".$Fin."','".$Tipo."')");
            $sql->execute();
            $sql = $this->con->prepare("SELECT Limpieza_ID FROM limpieza 
            WHERE BINARY Limpieza_Usuario = '".$Usuario."'
            AND BINARY Limpieza_HoraInicio = '".$Inicio."'
            AND BINARY Limpieza_HoraFin = '".$Fin."'");
            $sql->execute();
            $res = $sql->fetchall();
            $ID = $res[0]['Limpieza_ID'];
            return $ID;
        }


    
    }

?>