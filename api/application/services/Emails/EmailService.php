<?php

namespace Api\Services\Emails;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Model/EmailDestinationModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";

class EmailService
{
    public function sendUserCreatedEmail($createUserResponse)
    {
        $subject = "Usuario " . $createUserResponse->getRolNombre() . " creado en Sistema de gestión de turnos para guías de Turismo";
        $bodyMessage = $this->generateBodyMessage($createUserResponse);

        $emailDestinationModel = new \EmailDestinationModel(
            $createUserResponse->getEmail(),
            $createUserResponse->getNombre(),
            $subject,
            $bodyMessage
        );

        $emailServerService = \DependencyInjection::getEmailSenderServce();
        $emailResponse = $emailServerService->send($emailDestinationModel);

        if (strstr($emailResponse, "No pudo ser enviada")) {
            throw new \Exception("Error al enviar el correo.");
        }
    }

    private function generateBodyMessage($response)
    {
        $nombre = $response->getNombre();
        $email = $response->getEmail();
        $rol = $response->getRolNombre();
        $password = $response->getPassword();

        $uri = "/Views/Users/index.php";
        $parameters = "?action=activate&token=" . $response->getValidationToken() . "&id=" . $response->getId();
        $url = \UrlHelper::getUrl($uri);
        $url .= $parameters;

        $template = $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Views/Users/TemplateNotificacionNewUser.html";
        $htmlTemplate = file_get_contents($template);

        $htmlContent = str_replace(
            ['[[nombre]]', '[[email]]', '[[pass]]', '[[rol]]', '[[url]]'],
            [$nombre, $email, $password, $rol, $url],
            $htmlTemplate
        );

        return $htmlContent;
    }
}
