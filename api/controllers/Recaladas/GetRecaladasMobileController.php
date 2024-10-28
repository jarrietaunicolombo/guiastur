<?php

namespace Api\Controllers\Recaladas;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Services/Auth/AuthService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InvalidPermissionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Response/ResponseMiddleware.php";

use Api\Services\Auth\AuthService;
use Api\Middleware\Response\ResponseMiddleware;

class GetRecaladasMobileController
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function handleRequest(array $request)
    {
        try {

            $authHeader = $this->getAuthorizationHeader();

            $decodedToken = $this->authService->validateToken($authHeader);

            $this->authService->checkRolePermission($decodedToken->data->role, ['Super Usuario', 'ADMIN']);

            $this->getRecaladas();

        } catch (\InvalidPermissionException $e) {
            ResponseMiddleware::error($e->getMessage(), 403);
        } catch (\Exception $e) {
            ResponseMiddleware::error("Error interno del servidor", 500);
        }
    }

    private function getAuthorizationHeader()
    {
        $headers = apache_request_headers();
        $authHeader = $headers['Authorization'] ?? null;

        if (!$authHeader) {
            throw new \InvalidPermissionException("Token de autorización no proporcionado.");
        }

        return $authHeader;
    }

    private function getRecaladas()
    {
        try {
            $service = \DependencyInjection::getRecaladasService();
            $response = $service->getRecaladas();

            $recaladasData = json_decode($response->toJSON(), true);

            if (isset($recaladasData['recaladas'])) {
                $recaladasData['recaladas'] = array_map(function($recalada) {
                    return json_decode($recalada, true);
                }, $recaladasData['recaladas']);

                ResponseMiddleware::success($recaladasData);
            } else {
                throw new \Exception("Error al procesar recaladas.");
            }

        } catch (\Exception $e) {
            ResponseMiddleware::error($e->getMessage(), 500);
        }
    }

}
