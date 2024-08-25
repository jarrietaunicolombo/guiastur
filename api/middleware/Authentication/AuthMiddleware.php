<?php

namespace App\api\Middleware\Authentication;

use App\Helpers\JWTHandler;
use Exception;

class AuthMiddleware
{
    public function handle($request, $next)
    {
        try {
            if (!isset($request->headers['Authorization'])) {
                throw new Exception('Token no proporcionado.');
            }

            $token = str_replace('Bearer ', '', $request->headers['Authorization']);

            $decoded = JWTHandler::decode($token);

            if ($decoded->role !== 'admin') {
                throw new Exception('Permisos insuficientes.');
            }

            return $next($request);
        } catch (Exception $e) {
            http_response_code(403);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }
}
