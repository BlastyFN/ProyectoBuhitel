<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';
    class mailer{
        private $direccion;
        private $clave;
        private $mail;
        public function __construct(){
            $this->direccion = 'buhitels@gmail.com';
            $this->clave = 'BuhitelCeti2022';
            $this->mail= new PHPMailer(true);
        }
        public function enviarCorreo($destinatario, $titulo, $mensaje){
            try {
                //Configuración del SMTP
                $this->mail->SMTPDebug = 0;                      //Quitar el debug de la impresión del php
                $this->mail->isSMTP();                                            //Habilita el correo para que use SMTP
                $this->mail->Host       = 'smtp.gmail.com';                     //La dirección del SMTP
                $this->mail->SMTPAuth   = true;                                   //Advierte de la autenticación del SMTP
                $this->mail->Username   = $this->direccion;                     //Determino el correo
                $this->mail->Password   = $this->clave;                               //Determino la contraseña
                $this->mail->SMTPSecure = 'ssl';            //Determina la seguridad
                $this->mail->Port       = 465;                                    //Determina el puerto
            
                //COnfiguración del emisor y receptor
                $this->mail->setFrom($this->direccion, 'Buhi'); //Determino el correo emisor
                $this->mail->addAddress($destinatario);     //Determino el receptor
            
                //Contenido
                $this->mail->isHTML(true);
                $this->mail->Subject = $titulo; //Determino el titulo del correo
                $this->mail->Body    = $mensaje; //Determino el cuerpo del correo
            
                $this->mail->send();
                echo 'Exito';
            } catch (Exception $e) {
                echo "Ocurrió un error: {$this->mail->ErrorInfo}";
            }
        }
        
    }
    

?>