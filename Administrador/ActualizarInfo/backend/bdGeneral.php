<?php 
    class database{
        private $con;
        function __construct(){
            $this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022');
        }
        //funciones
        public function consultarPregunta($Hotel){
            $sql = $this->con->prepare("SELECT Twilio_PreguntaAbierta FROM twilio
            WHERE BINARY Twilio_Hotel = '".$Hotel."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function consultarRespuesta($Hotel, $Hoy, $HaceUnMes){
            $sql = $this->con->prepare("SELECT Respuestas_ID, Respuestas_HabReservadas, Respuesta_NumPregunta, Respuesta_Valor FROM respuestasencuesta
            INNER JOIN habitacionreservada ON habitacionreservada.HabReservada_ID = Respuestas_HabReservadas
            INNER JOIN reservacion ON reservacion.Reservacion_ID = habitacionreservada.HabReservada_Reservacion
            INNER JOIN habitacion ON habitacion.Habitacion_ID = habitacionreservada.HabReservada_Habitacion
            INNER JOIN piso ON piso.Piso_ID = habitacion.Habitacion_Piso
            WHERE BINARY piso.Piso_Hotel = '".$Hotel."'
            AND BINARY Reservacion_CheckOut BETWEEN '".$Hoy."' AND '".$HaceUnMes."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }

        public function actualizarPregunta($Pregunta, $Hotel){
            $sql = $this->con->prepare("UPDATE twilio 
            SET Twilio_PreguntaAbierta='".$Pregunta."' 
            WHERE BINARY Twilio_Hotel='".$Hotel."'");
            $sql->execute();
            return "Pregunta actualizada con éxito";
        }
        
        public function insertarPregunta($Pregunta, $Hotel){
            $sql = $this->con->prepare( "INSERT INTO twilio (Twilio_Hotel, Twilio_PreguntaAbierta) 
	    	VALUES ('".$Hotel."','".$Pregunta."')");
            $sql->execute();
            return "Pregunta insertada con éxito";
        }

        
    }

?>