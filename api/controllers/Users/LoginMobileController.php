<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/JWTHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/CookiesSetup.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Exceptions/UnauthorizedException.php";

use Api\Exceptions\UnauthorizedException;
use Api\Helpers\JWTHandler;
use Api\Helpers\CookiesSetup;

class LoginController
{
    public function handleRequest(array $request)
    {
        if ($request["action"] === "login") {
            $this->login($request);
        }
    }

    private function login(array $request)
    {
        try {
            ob_start();

            $email = trim($request['email']);
            $password = trim($request['password']);
            error_log("Intentando login con Email: $email");

            $loginRequest = new LoginRequest($email, $password);
            $loginUseCase = DependencyInjection::getLoginServce();
            $loginResponse = $loginUseCase->login($loginRequest);

            if (!$loginResponse) {
                throw new UnauthorizedException("Credenciales incorrectas.");
            }

            error_log("Login exitoso para usuario ID: " . $loginResponse->getId());

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

            $this->sendSuccessResponse([
                "message" => "Login exitoso.",
                "token" => $authToken,
                "refresh_token" => $refreshToken
            ]);
        } catch (UnauthorizedException $e) {
            ob_end_clean();
            $this->sendErrorResponse($e->getMessage(), 401);
        } catch (\Exception $e) {
            error_log("Error inesperado: " . $e->getMessage());
            ob_end_clean();
            $this->sendErrorResponse("Error en la autenticación: " . $e->getMessage(), 400);
        }
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
