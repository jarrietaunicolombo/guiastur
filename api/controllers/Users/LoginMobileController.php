<?php

namespace Api\Controllers\Users;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/JWTHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/CookiesSetup.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Exceptions/UnauthorizedException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Services/Auth/LoginService.php";

use Api\Exceptions\UnauthorizedException;
use Api\Helpers\JWTHandler;
use Api\Helpers\CookiesSetup;
use Api\Services\Auth\LoginService;

class LoginController
{
    private $loginService;

    public function __construct()
    {
        $this->loginService = new LoginService();
    }

    public function handleRequest(array $request)
    {
        if ($request["action"] === "login") {
            $this->login($request);
        }
    }

    private function login(array $request)
    {
        try {
            error_log("Login attempt: " . json_encode($request)); // Agregar log
            ob_start();

            $email = trim($request['email']);
            $password = trim($request['password']);

            error_log("Email: $email, Password: (hidden)"); // Agregar log

            $loginResponse = $this->loginService->login($email, $password);

            $tokenData = [
                'userId' => $loginResponse->getId(),
                'role' => $loginResponse->getRol()
            ];

            $authToken = JWTHandler::createToken($tokenData);
            $refreshToken = JWTHandler::createToken(['userId' => $loginResponse->getId()]);

            $cookies = new CookiesSetup();
            $cookies->setAuthTokenCookie($authToken);
            $cookies->setRefreshTokenCookie($refreshToken);

            ob_end_clean();

            error_log("Login successful, userId: " . $loginResponse->getId()); // Agregar log

            $this->sendSuccessResponse([
                "message" => "Login exitoso.",
                "token" => $authToken,
                "refresh_token" => $refreshToken
            ]);
        } catch (UnauthorizedException $e) {
            ob_end_clean();
            error_log("UnauthorizedException: " . $e->getMessage()); // Agregar log
            $this->sendErrorResponse($e->getMessage(), 401);
        } catch (\Exception $e) {
            ob_end_clean();
            error_log("Exception: " . $e->getMessage()); // Agregar log
            $this->sendErrorResponse("Error en la autenticación: " . $e->getMessage(), 400);
        }
    }

    private function sendSuccessResponse($data)
    {
        error_log("Respuesta exitosa de login: " . json_encode($data)); // Añadir este log
        echo json_encode($data);
        http_response_code(200);
        exit();
    }

    private function sendErrorResponse($message, $code = 400)
    {
        error_log("Error en login: " . $message); // Añadir este log
        echo json_encode(["error" => $message]);
        http_response_code($code);
        exit();
    }
}
