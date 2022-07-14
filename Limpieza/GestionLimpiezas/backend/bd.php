<?php 
    class database{
        private $con;
        function __construct(){
            $this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022');
        }
        //funciones
        

        public function consultarLimpiezas($Usuario, $Hoy, $Mañana){
            $sql = $this->con->prepare("SELECT Limpieza_ID, Limpieza_HoraInicio, Limpieza_HoraFin, piso.Piso_Numero, Limpieza_Tipo, habitacion.Habitacion_Nombre, estatuslimpieza.EstatusLimpieza_Nombre FROM limpieza
			INNER JOIN habitacion ON habitacion.Habitacion_ID = Limpieza_Habitacion
			INNER JOIN estatuslimpieza ON estatuslimpieza.EstatusLimpieza_ID = Limpieza_Estatus
			INNER JOIN piso ON piso.Piso_ID = habitacion.Habitacion_Piso
			WHERE BINARY Limpieza_Usuario = '".$Usuario."'
			AND BINARY Limpieza_HoraInicio BETWEEN '".$Hoy."' AND '".$Mañana."'
            AND BINARY Limpieza_Estatus != '3'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function cambiarEstatus($Limpieza, $Notas, $Estatus){
            $sql = $this->con->prepare("UPDATE limpieza 
            SET Limpieza_Notas= '".$Notas."', Limpieza_Estatus='".$Estatus."' 
            WHERE Limpieza_ID = '".$Limpieza."'");
            $sql->execute();
            return '1';
        }

        public function obtenerNumero($Limpieza, $Hoy){
            $sql = $this->con->prepare("SELECT habitacionreservada.HabReservada_NumWhatsapp FROM limpieza
            INNER JOIN habitacion ON habitacion.Habitacion_ID = Limpieza_Habitacion
            INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_Habitacion = habitacion.Habitacion_ID
            INNER JOIN reservacion ON reservacion.Reservacion_ID = habitacionreservada.HabReservada_Reservacion
            WHERE BINARY Limpieza_ID = '".$Limpieza."'
            AND BINARY '".$Hoy."' BETWEEN reservacion.Reservacion_CheckIn AND reservacion.Reservacion_CheckOut");
            $sql->execute();
            $res = $sql->fetchall();
            $num;
            if ($res[0]['HabReservada_NumWhatsapp'] != '0') {
                $num = $res[0]['HabReservada_NumWhatsapp'];
            }
            else{
                $num = false;
            }
            return $num;
        }


    }

?>