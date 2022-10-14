<?php 
    class database{
        private $con;
        function __construct(){
            $this->con = new PDO ('mysql:host = localhost;dbname=corpo206_buhitel','corpo206_gestorbuhi','ProyectoBuhitel2022');
        }
        //funciones
        public function consultarEstados($Hotel){
            $sql = $this->con->prepare("SELECT Twilio_ChatBot, Twilio_Servicio, Twilio_Limpieza, Twilio_Valet FROM twilio
            WHERE BINARY Twilio_Hotel = '".$Hotel."'");
            $sql->execute();
            $res = $sql->fetchall();
            return $res;
        }
        
        public function actualizarEstado($Hotel, $Campo, $Valor){
            $sql = $this->con->prepare("UPDATE twilio 
            SET ".$Campo."='".$Valor."' 
            WHERE BINARY Twilio_Hotel='".$Hotel."'");
            $sql->execute();
            return "Pregunta actualizada con éxito";
        }
        
        
    }

?>