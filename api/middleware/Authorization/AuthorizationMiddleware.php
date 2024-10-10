<?php

namespace Api\Middleware\Authorization;

class AuthorizationMiddleware
{
    public static function checkRolePermission($userRole, $requiredRoles)
    {

        if (!in_array($userRole, $requiredRoles)) {
            error_log("Error: Rol '$userRole' no tiene permiso para realizar esta acción.");
            throw new \Exception('No tiene permiso para realizar esta acción.');
        }
    }
}
