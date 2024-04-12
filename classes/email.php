<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;

    }

    public function enviarConfirmacion() {
        //Creamos una nueva instancia, true para ver detalladamente los errores
        $mail = new PHPMailer();
        //Configurar SMPT, SMPT es el protocolo para el envio de emails
        //Utilizaremos SMTP
        $mail->isSMTP();
        //Host de nuestro mailtrap
        $mail->Host = $_ENV['EMAIL_HOST'];
        //Autenticar
        $mail->SMTPAuth = true;
        //Credenciales
        $mail->Username   = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        //Nuetros correos iran por un medio seguro
        $mail->SMTPSecure = 'tls';
        //Puerto de Mailtrap
        $mail->Port = $_ENV['EMAIL_PORT'];

        //Destinatarios
        //Quien envia el email
        $mail->setFrom('admin@bienesraicesagus.com');
        //Quien recibe el correo, el correo es opcional
        $mail->addAddress($this->email, $this->nombre);     

        //Contenido del mail
        //Poner asunto
        $mail->Subject = 'Correo de confirmacion de cuenta';
        //Para habilitar el contenido html del cuerpo del correo
        $mail->isHTML(true);  
        //Para habilitar acentos y ñ
        $mail->CharSet = 'UTF-8'; 
        //Escribiendo el contenido en html
        $contenido = '<html>';
        $contenido .='<p>Hola  ' . $this->nombre . '</p>';
        $contenido .='<p>Has creado tu cuenta solo debes de confirmarla presionando el siguiente enlace</p>';
        $contenido .="<p>Presiona aqui para confirmarla: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar cuenta</a> </p>";
        $contenido .='<p>Si tu no solicitaste esta cuenta puedes ignorar el mensaje</p>';
        $contenido .= '</html>';
        //Asignando el contenido al cuerpo
        $mail->Body = $contenido;
        $mail->AltBody = 'Texto sin html';
        //Metodo para enviar el correo, este metodo retorna true o false
        $mail->send();

    }

    public function enviarInstrucciones() {
        //Creamos una nueva instancia, true para ver detalladamente los errores
        $mail = new PHPMailer();
        //Configurar SMPT, SMPT es el protocolo para el envio de emails
        //Utilizaremos SMTP
        $mail->isSMTP();
        //Host de nuestro mailtrap
        $mail->Host = $_ENV['EMAIL_HOST'];
        //Autenticar
        $mail->SMTPAuth = true;
        //Credenciales
        $mail->Username   = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        //Nuetros correos iran por un medio seguro
        $mail->SMTPSecure = 'tls';
        //Puerto de Mailtrap
        $mail->Port = $_ENV['EMAIL_PORT'];
        //Destinatarios
        //Quien envia el email
        $mail->setFrom('admin@bienesraicesagus.com');
        //Quien recibe el correo, el nombre es opcional
        $mail->addAddress($this->email, $this->nombre);     

        //Contenido del mail
        //Poner asunto
        $mail->Subject = 'Rsestablece tu contraseña';
        //Para habilitar el contenido html del cuerpo del correo
        $mail->isHTML(true);  
        //Para habilitar acentos y ñ
        $mail->CharSet = 'UTF-8'; 
        //Escribiendo el contenido en html
        $contenido = '<html>';
        $contenido .='<p>Hola  ' . $this->nombre . '</p>';
        $contenido .='<p>Has solicitado restablecer tu contraseña</p>';
        $contenido .="<p>Presiona aqui para restablecerla: <a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'>Reestablecer contraseña</a> </p>";
        $contenido .='<p>Si tu no solicitaste esta cuenta puedes ignorar el mensaje</p>';
        $contenido .= '</html>';
        //Asignando el contenido al cuerpo
        $mail->Body = $contenido;
        $mail->AltBody = 'Texto sin html';
        //Metodo para enviar el correo, este metodo retorna true o false
        $mail->send();
    }
}