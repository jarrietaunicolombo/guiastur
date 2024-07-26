<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/ExternalServices/IEmailSenderService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Libs/PHPMailer-6.0.0/src/PHPMailer.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Libs/PHPMailer-6.0.0/src/Exception.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Libs/PHPMailer-6.0.0/src/SMTP.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Model/EmailDestinationModel.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


class EmailSenderService implements IEmailSenderService {

    private $mailer;
    private $host = "smtp.gmail.com";
    // private $host = "smtp-mail.outlook.com";
    private $userServer = 'gestionguiasturismo@gmail.com';
    private $userName = 'Gestor de Turnos Para Guias de Turismo';
    private $passServer = "ljqw kcyr mdkn yvcc";
    private $smtpSecure = "tls";
    private $portServer = 587;

    public function __construct() {
        $this->mailer =  new PHPMailer(true);
    }

    private function config() {
        $this->mailer->isSMTP();
        $this->mailer->SMTPDebug = 0;
        $this->mailer->SMTPAuth = true;
        // $mail->Host = 'smtp.gmail.com';
        $this->mailer->Host = $this->host;
        $this->mailer->SMTPAuth = true;
        // $mail->Username = 'usuario@gmail.com';
        $this->mailer->Username = $this->userServer;
        $this->mailer->Password = $this->passServer;
        $this->mailer->SMTPSecure = $this->smtpSecure;
        $this->mailer->Port = $this->portServer;
    }

    public function send(EmailDestinationModel $request) : string{
        try{
            $this->config();
            $dateTime = (new DateTime())->format("Y-m-d H:i:s");
            $responseMessage = "Revise su correo ". $request->getDestinationEmail() . " para mayor informacion";
            $this->mailer->setFrom($this->userServer,$this->userName);
            $this->mailer->addAddress($request->getDestinationEmail(), $request->getDestinationName());
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $request->getSubject();
            $this->mailer->Body = $request->getBody();
            $this->mailer->send();
            return $responseMessage;
        } catch (Exception $e) {
            $errorMessage = "No pudo ser enviada la notificacion al correo ".$request->getDestinationEmail().", ERROR: ".$e->getMessage();
            return $errorMessage ;
        } 
    }
}
