<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Auth/AuthService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Users/UserService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Emails/EmailService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Utilities/UtilityService.php";

use Api\Services\AuthService;
use Api\Services\UserService;
use Api\Services\Emails\EmailService;
use Api\Services\Utilities\UtilityService;

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
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return $this->sendErrorResponse("Método no permitido", 405);
        }

        $this->createUser($request);
    }

    private function createUser(array $request)
    {
        try {
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
            $this->authService->checkRolePermission($userRole, [RolTypeEnum::SUPERVISOR, RolTypeEnum::SUPER_USUARIO]);

            $email = trim($request['email'] ?? '');
            $nombre = trim($request['nombre'] ?? '');
            $rol_id = $request['rol_id'] ?? null;

            if (empty($email) || empty($nombre) || !$rol_id) {
                throw new \InvalidArgumentException("El Email, Nombre y Rol son requeridos.");
            }

            $password = $this->utilityService->generatePassword();
            $createUserResponse = $this->userService->createUser($email, $password, $nombre, $rol_id, $decodedToken->data->userId);

            $this->emailService->sendUserCreatedEmail($createUserResponse);

            $this->sendSuccessResponse([
                "id" => $createUserResponse->getId(),
                "message" => "Usuario creado exitosamente.",
                "email" => $createUserResponse->getEmail(),
                "rol" => $createUserResponse->getRolNombre()
            ]);
        } catch (\InvalidArgumentException $e) {
            $this->sendErrorResponse($e->getMessage(), 400);
        } catch (\Exception $e) {
            $this->sendErrorResponse("Error interno en el servidor.", 500);
        }
    }

    private function sendSuccessResponse($data)
    {
        http_response_code(200);
        echo json_encode($data);
        exit();
    }

    private function sendErrorResponse($message, $code = 400)
    {
        http_response_code($code);
        echo json_encode(["error" => $message]);
        exit();
    }
}
