<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/ExternalServices/EmailSender.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/ExternalServices/EmailSender.php";
class TestEmailSender{
    public static function testSendEmailShouldShowResponseMessage(){
        // Arrange
        $destinationEmail = "jarrietaarrieta@hotmail.com";
        $destinationName = "JOHN CARLOS ARRIETA ARRIETA";
        $subject = "Notificacion de prueba";
        $body = "Si ves esto es porque funciona el notificador de mensajes por correo";
        $notificationRequest = new EmailDestinationModel($destinationEmail, $destinationName, $subject, $body); 
        $mailler = new EmailSender() ;
        // Act
        $responseMessage = $mailler->send($notificationRequest);
        // Assert
        echo  $responseMessage;
    }

}
TestEmailSender::testSendEmailShouldShowResponseMessage();