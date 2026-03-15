<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Users/UserService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Response/ResponseMiddleware.php";

use Api\Services\UserService;
use Api\Middleware\Response\ResponseMiddleware;

class GetAllRolesMobileController
{
    public static function handleRequest()
    {
        try {
            error_log("🔍 GetAllRolesMobileController: Iniciando obtención de roles");
            $service = new UserService();
            $roles = $service->getRoles();
            error_log("✅ GetAllRolesMobileController: Roles obtenidos correctamente");

            $formatted = array_map(function ($rol) {
                return [
                    'id' => $rol->id,
                    'name' => $rol->nombre,
                    'description' => $rol->descripcion,
                    'icon' => $rol->icono
                ];
            }, $roles);

            ResponseMiddleware::success($formatted);
        } catch (\Exception $e) {
            error_log("❌ GetAllRolesMobileController: Error - " . $e->getMessage());
            ResponseMiddleware::error(['error' => $e->getMessage()], 500);
        }
    }
}
