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
        $this->sid = "AC479a3f0203ff0e309abb54e9dd4ebb8f";
        $this->token = "4112f31af823f40d1691b818e78cf5d5";
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