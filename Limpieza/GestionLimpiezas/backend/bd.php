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
			AND BINARY Limpieza_HoraInicio BETWEEN '".$Hoy."' AND '".$Mañana."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }


    }

?>