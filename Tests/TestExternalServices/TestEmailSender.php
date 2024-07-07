<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/ExternalServices/EmailSenderService.php";

class TestEmailSender{
    public static function testSendEmailShouldShowResponseMessage(){
        // Arrange
        $destinationEmail = "92031576@yopmail.com";
        $destinationName = "JOHN CARLOS ARRIETA ARRIETA";
        $subject = "Notificacion de prueba";
        $body = "Si ves esto es porque funciona el notificador de mensajes por correo";
        $notificationRequest = new EmailDestinationModel($destinationEmail, $destinationName, $subject, $body); 
        $mailler = new EmailSenderService() ;
        // Act
        $responseMessage = $mailler->send($notificationRequest);
        // Assert
        echo  $responseMessage;
    }

}
TestEmailSender::testSendEmailShouldShowResponseMessage();