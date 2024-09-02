<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/JWTHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Constants/RolTypeEnum.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/Dto/CreateUserRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/Dto/CreateUserResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InvalidPermissionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Model/EmailDestinationModel.php";

use Api\Helpers\JWTHandler;

class CreateUserMobileController
{
    public function handleRequest($request)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->createUser($request);
        } else {
            $this->sendErrorResponse("Método no permitido", 405);
        }
    }

    private function createUser(array $request)
    {
        try {
            $headers = apache_request_headers();
            $authHeader = $headers['Authorization'] ?? '';
            error_log("Authorization Header: " . $authHeader);

            if (strpos($authHeader, 'Bearer ') === 0) {
                $token = str_replace('Bearer ', '', $authHeader);
                error_log("Token extraído: " . $token);
            } else {
                throw new InvalidPermissionException("Token no proporcionado.");
            }

            if (!JWTHandler::validateToken($token)) {
                throw new InvalidPermissionException("Token no válido o expirado.");
            }

            $decodedToken = JWTHandler::decodeJWT($token);
            error_log("Decoded Token: " . print_r($decodedToken, true));

            $userRole = $decodedToken->data->role;
            error_log("Rol del usuario: " . $userRole);

            if ($userRole == RolTypeEnum::GUIA || $userRole == RolTypeEnum::USUARIO) {
                throw new InvalidPermissionException("No tiene permisos para crear Usuarios.");
            }

            $rolesResponse = DependencyInjection::getRolesServce()->getRoles();
            $roles = $rolesResponse->getRoles();
            $rol_id = (int) $request['rol_id'] ?? null;

            if (!$rol_id || empty($rol_id)) {
                throw new InvalidRequestParameterException("El Rol es requerido.");
            }

            $rolSelected = array_filter($roles, function ($rol) use ($rol_id) {
                return $rol->getId() === $rol_id;
            });

            if (empty($rolSelected)) {
                throw new InvalidPermissionException("No tiene permisos suficientes.");
            }

            $rolSelected = reset($rolSelected);
            error_log("Rol seleccionado: " . print_r($rolSelected, true));

            if (
                $userRole === RolTypeEnum::SUPERVISOR
                && ($rolSelected->getNombre() === RolTypeEnum::SUPER_USUARIO || $rolSelected->getNombre() === RolTypeEnum::SUPERVISOR)
            ) {
                throw new InvalidPermissionException("No tiene permisos para crear este tipo de usuarios.");
            }

            $email = $request['email'] ?? null;
            $nombre = $request['nombre'] ?? null;
            $password = Utility::generateGUID(2); // Genera un GUID para el password

            if (!$email || empty(trim($email))) {
                throw new InvalidRequestParameterException("El Email es requerido.");
            }

            if (!$nombre || empty(trim($nombre))) {
                throw new InvalidRequestParameterException("El Nombre es requerido.");
            }

            error_log("Datos de usuario: Email: " . $email . ", Nombre: " . $nombre);

            $createUserRequest = new CreateUserRequest(
                $email,
                $password,
                $nombre,
                $rol_id,
                $decodedToken->data->userId
            );

            $createUserUseCase = DependencyInjection::getCreateUserServce();
            $createUserResponse = $createUserUseCase->createUser($createUserRequest);

            error_log("Usuario creado: ID: " . $createUserResponse->getId());

            // Envío del correo electrónico
            $subjetMessage = "Usuario " . $createUserResponse->getRolNombre() . " creado en Sistema de gestión de turnos para guías de Turismo";
            $bodyMessage = $this->generateBodyMessage($createUserResponse);
            $emailDestinationModel = new EmailDestinationModel(
                $createUserResponse->getEmail(),
                $createUserResponse->getNombre(),
                $subjetMessage,
                $bodyMessage
            );
            $emailServerService = DependencyInjection::getEmailSenderServce();
            $emailResponse = $emailServerService->send($emailDestinationModel);
            if (strstr($emailResponse, "No pudo ser enviada")) {
                throw new EmailSenderException($emailResponse);
            }

            $this->sendSuccessResponse([
                "id" => $createUserResponse->getId(),
                "message" => "Usuario creado exitosamente.",
                "email" => $createUserResponse->getEmail(),
                "rol" => $createUserResponse->getRolNombre()
            ]);
        } catch (InvalidPermissionException $e) {
            error_log("Error de permisos: " . $e->getMessage());
            $this->sendErrorResponse($e->getMessage(), 403);
        } catch (\Exception $e) {
            error_log("Error al crear el usuario: " . $e->getMessage());
            $this->sendErrorResponse("Error al crear el usuario: " . $e->getMessage(), 400);
        }
    }

    private function generateBodyMessage(CreateUserResponse $response)
    {
        $nombre = $response->getNombre();
        $email = $response->getEmail();
        $rol = $response->getRolNombre();
        $password = $response->getPassword();
        $uri = "/Views/Users/index.php";
        $parameters = "?action=activate&token=" . $response->getValidationToken() . "&id=" . $response->getId();
        $url = UrlHelper::getUrl($uri);
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

    private function sendSuccessResponse($data)
    {
        echo json_encode($data);
        http_response_code(200);
        exit();
    }

    private function sendErrorResponse($message, $code = 400)
    {
        echo json_encode(["error" => $message]);
        http_response_code($code);
        exit();
    }
}
