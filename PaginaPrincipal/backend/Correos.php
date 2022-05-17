<?php 
    class mailer{
        private $Origen;
        function __construct()
        {
           $this->Origen = 'From: a18100024@ceti.mx';
        }   
        
        public function enviarCorreo($Correo, $Titulo, $Mensaje){
            $status;
            if (mail($Correo, $Titulo, $Mensaje, $Origen)) {//The mail was sent correctly
				$status = "1";
			} else {
                $status = "0";
            }
            return $status;
        }

    }
    


?>