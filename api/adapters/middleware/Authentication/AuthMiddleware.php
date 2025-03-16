<?php

namespace Api\Middleware\Authentication;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/infrastructure/Helpers/JWTHandler.php";

use Api\Helpers\JWTHandler;

class AuthMiddleware
{
    public function handle($next)
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $token = str_replace('Bearer ', '', $authHeader);

        if (empty($token)) {
            $this->sendErrorResponse("Token no proporcionado.", 401);
        }

        if (!JWTHandler::validateToken($token)) {
            $this->sendErrorResponse("Token no válido o expirado.", 401);
        }

        return $next();
    }

    public static function authenticate()
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $token = str_replace('Bearer ', '', $authHeader);

        if (empty($token)) {
            http_response_code(401);
            echo json_encode(["error" => "Token no proporcionado."]);
            exit();
        }

        $user = JWTHandler::validateToken($token);
        if (!$user) {
            http_response_code(401);
            echo json_encode(["error" => "Token no válido o expirado."]);
            exit();
        }

        return $user; // Retorna el usuario autenticado
    }

    private function sendErrorResponse($message, $code = 400)
    {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode(["error" => $message]);
        exit();
    }
}
