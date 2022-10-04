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

        public function actualizarPregunta($Pregunta, $Hotel){
            $sql = $this->con->prepare("UPDATE twilio 
            SET Twilio_PreguntaAbierta='".$Pregunta."', 
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