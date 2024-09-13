<?php
class AuthorizationMiddleware
{
    public static function checkRolePermission($userRole, $requiredRoles)
    {
        error_log("Rol del usuario: " . $userRole);
        error_log("Roles requeridos: " . implode(', ', $requiredRoles));

        if (!in_array($userRole, $requiredRoles)) {
            error_log("Error: Rol '$userRole' no tiene permiso para realizar esta acción.");
            throw new \Exception('No tiene permiso para realizar esta acción.');
        }
    }
}
