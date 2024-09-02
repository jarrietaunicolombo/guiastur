<?php

namespace Api\Middleware;

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

    private function sendErrorResponse($message, $code = 400)
    {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode(["error" => $message]);
        exit();
    }
}
