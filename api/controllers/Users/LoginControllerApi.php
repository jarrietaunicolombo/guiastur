<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/JWTHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/CookiesSetup.php"; // Incluir el controlador de Cookies
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
            // Captura cualquier salida accidental
            ob_start();

            $email = $request['email'];
            $password = $request['password'];

            $loginRequest = new LoginRequest($email, $password);
            $loginUseCase = DependencyInjection::getLoginServce();
            $loginResponse = $loginUseCase->login($loginRequest);

            if (!$loginResponse) {
                throw new UnauthorizedException("Credenciales incorrectas.");
            }

            $tokenData = [
                'userId' => $loginResponse->getId(),
                'role' => $loginResponse->getRol()
            ];

            // Generar el token JWT
            $token = JWTHandler::createToken($tokenData);

            $cookies = new CookiesSetup();
            $cookies->setAuthTokenCookie($token);

            ob_end_clean();

            $this->sendSuccessResponse([
                "message" => "Login exitoso."
            ]);
        } catch (UnauthorizedException $e) {
            ob_end_clean();
            $this->sendErrorResponse($e->getMessage(), 401);
        } catch (\Exception $e) {
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
