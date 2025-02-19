<?php

namespace Api\Services\Auth;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/JWTHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Constants/RolTypeEnum.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InvalidPermissionException.php";

use Api\Helpers\JWTHandler;

class AuthService
{
    public function validateToken($authHeader)
    {
    
        if (strpos($authHeader, 'Bearer ') === 0) {
            $token = str_replace('Bearer ', '', $authHeader);
            error_log("Token extraído: " . $token);
        } else {
            error_log("Error: No se proporcionó un token válido.");
            throw new \InvalidPermissionException("Token no proporcionado.");
        }
    
        if (!JWTHandler::validateToken($token)) {
            error_log("Error: Token inválido o expirado.");
            throw new \InvalidPermissionException("Token no válido o expirado.");
        }
    
        return JWTHandler::decodeJWT($token);
    }

    public function checkRolePermission($userRole, $requiredRoles)
    {
        if (!in_array($userRole, $requiredRoles)) {
            throw new \InvalidPermissionException("No tiene permisos suficientes.");
        }
    }
}
