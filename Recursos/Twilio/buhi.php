<?php

// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md
require_once '/twilio-php-main/src/twilio/autoload.php';

use Twilio\Rest\Client;



print($message->sid);
class buhi{
    private $con;
    function __construct(){
        $sid = "AC479a3f0203ff0e309abb54e9dd4ebb8f";
        $token = "08e57113d4b0e83f20019378433cd015";
        $twilio = new Client($sid, $token);
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