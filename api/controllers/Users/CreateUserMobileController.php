<?php

namespace Api\Controllers\Users;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Auth/AuthService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Users/UserService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Emails/EmailService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Utilities/UtilityService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Request/RequestMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Authorization/AuthorizationMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Response/ResponseMiddleware.php";

use Api\Services\Auth\AuthService;
use Api\Services\UserService;
use Api\Services\Emails\EmailService;
use Api\Services\Utilities\UtilityService;
use Api\Middleware\Request\RequestMiddleware;
use Api\Middleware\Authorization\AuthorizationMiddleware;
use Api\Middleware\Response\ResponseMiddleware;

class CreateUserMobileController
{
    private $authService;
    private $userService;
    private $emailService;
    private $utilityService;

    public function __construct()
    {
        $this->authService = new AuthService();
        $this->userService = new UserService();
        $this->emailService = new EmailService();
        $this->utilityService = new UtilityService();
    }

    public function handleRequest($request)
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                throw new \InvalidArgumentException("Método no permitido.");
            }

            RequestMiddleware::validateCreateUserRequest($request);

            $headers = apache_request_headers();
            $authHeader = $headers['Authorization'] ?? '';
            if (!$authHeader) {
                throw new \InvalidArgumentException("Authorization header no proporcionado.");
            }

            $decodedToken = $this->authService->validateToken($authHeader);
            if (!$decodedToken) {
                throw new \InvalidArgumentException("Token inválido.");
            }

            $userRole = $decodedToken->data->role;
            AuthorizationMiddleware::checkRolePermission($userRole, [\RolTypeEnum::SUPERVISOR, \RolTypeEnum::SUPER_USUARIO]);

            $email = trim($request['email']);
            $nombre = trim($request['nombre']);
            $rol_id = $request['rol_id'];

            $password = $this->utilityService->generatePassword();
            $createUserResponse = $this->userService->createUser($email, $password, $nombre, $rol_id, $decodedToken->data->userId);

            $this->emailService->sendUserCreatedEmail($createUserResponse);

            ResponseMiddleware::success([
                "id" => $createUserResponse->getId(),
                "message" => "Usuario creado exitosamente.",
                "email" => $createUserResponse->getEmail(),
                "rol" => $createUserResponse->getRolNombre()
            ]);
        } catch (\InvalidArgumentException $e) {
            ResponseMiddleware::error($e->getMessage(), 400);
        } catch (\Exception $e) {
            ResponseMiddleware::error("Error interno en el servidor.", 500);
        }
    }
}
