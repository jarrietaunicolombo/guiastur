<?php

namespace Api\Middleware\Authorization;

class AuthorizationMiddleware
{
    public static function checkRolePermission($userRole, $requiredRoles)
    {

        if (!in_array($userRole, $requiredRoles)) {
            throw new \Exception('No tiene permiso para realizar esta acción.');
        }
    }
}
