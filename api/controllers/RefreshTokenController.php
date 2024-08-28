<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/JWTHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/CookiesSetup.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Exceptions/UnauthorizedException.php";

use Api\Helpers\JWTHandler;
use Api\Helpers\CookiesSetup;
use Api\Exceptions\UnauthorizedException;

class RefreshTokenController
{
    public function handleRequest()
    {
        try {
            $cookies = new CookiesSetup();
            $refreshToken = $cookies->getRefreshTokenFromCookie();

            if (!$refreshToken) {
                throw new UnauthorizedException("Refresh token no encontrado.");
            }

            $tokenData = JWTHandler::validateToken($refreshToken);
            if (!$tokenData) {
                throw new UnauthorizedException("Refresh token inválido o expirado.");
            }

            $newAccessToken = JWTHandler::createToken([
                'userId' => $tokenData['userId'],
                'role' => $tokenData['role']
            ]);

            $cookies->setAuthTokenCookie($newAccessToken);

            $this->sendSuccessResponse([
                "message" => "Token renovado exitosamente."
            ]);
        } catch (UnauthorizedException $e) {
            $this->sendErrorResponse($e->getMessage(), 401);
        } catch (\Exception $e) {
            $this->sendErrorResponse("Error al renovar el token: " . $e->getMessage(), 400);
        }
    }

    private function sendSuccessResponse($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        http_response_code(200);
        exit();
    }

    private function sendErrorResponse($message, $code = 400)
    {
        header('Content-Type: application/json');
        echo json_encode(["error" => $message]);
        http_response_code($code);
        exit();
    }
}
