<?php

// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md
require_once 'twilio-php-main/src/Twilio/autoload.php';

use Twilio\Rest\Client;

class buhi{
    private $sid;
    private $token;
    private $twilio;
    function __construct(){
        $this->sid = "";
        $this->token = "";
        $this->twilio = new Client($this->sid, $this->token);
    }
    //funciones
    public function enviarMensaje($Destinatario, $Mensaje){
        $message = $this->twilio->messages
                  ->create("whatsapp:+".$Destinatario, // to
                           [
                               "from" => "whatsapp:+14155238886",
                               "body" => $Mensaje
                           ]
                  );
        return true;
    }
}
?>