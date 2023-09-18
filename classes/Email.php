<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $email;
    public $nombre;
    public $token;

    public function __construct($nombre, $email, $token){
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }


    public function enviarConfirmacion(){

        // Crear el objeto para los E-Mails.
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASSWORD'];

        $mail->setFrom('cuentas@appsalon.com'); // Define el email y nombre del remitente del mensaje.
        $mail->addAddress('cuentas@appsalon.com', 'appsalon.com');
        $mail->Subject = 'Confirma tu Cuenta'; // Añade el asunto del email.

        // Set HTML.
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";

        $contenido = "<html>";
        $contenido.= "<p><strong>Un placer saludarte " . $this->nombre . ".</strong> Tu cuenta ha sido creada exitosamente en AppSalon. Si deseas confirmar tu
        solicitud, por favor presiona el siguiente enlace.</p>"; 
        $contenido.= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/confirm-account?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido.= "<p>Si tu no aperturaste esta cuenta, puedes ignorar este mensaje.</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // Enviar el E-Mail.
        $mail->send();
    }


    public function enviarInstrucciones(){
        // Crear el objeto para los E-Mails.
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASSWORD'];

        $mail->setFrom('cuentas@appsalon.com'); // Define el email y nombre del remitente del mensaje.
        $mail->addAddress('cuentas@appsalon.com', 'appsalon.com');
        $mail->Subject = 'Reestablece tu Contraseña'; // Añade el asunto del email.

        // Set HTML.
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";

        $contenido = "<html>";
        $contenido.= "<p><strong>Un placer saludarte " . $this->nombre . ".</strong> Has solicitado reestablecer tu contraseña. Sigue el siguiente enlace para
        confirmar tu solicitud.</p>"; 
        $contenido.= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/recovery?token=" . $this->token . "'>Reestablecer Contraseña</a></p>";
        $contenido.= "<p> Si tu no has solicitado esta accion, por favor, ignora este mensaje.</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // Enviar el E-Mail.
        $mail->send();
    }
}

