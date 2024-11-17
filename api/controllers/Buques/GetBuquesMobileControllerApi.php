<?php

namespace Api\Controllers\Buques;

use Api\Services\Auth\AuthService;
use Api\Middleware\Response\ResponseMiddleware;
use Api\Middleware\Authorization\AuthorizationMiddleware;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Auth/AuthService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Authorization/AuthorizationMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Response/ResponseMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";

class GetBuquesMobileControllerApi
{
    private $authService;
    private $getBuquesService;

    public function __construct()
    {
        try {
            $this->authService = new AuthService();
            $this->getBuquesService = \DependencyInjection::getBuquesService();
        } catch (\Exception $e) {
            $this->logError($e);
            ResponseMiddleware::error("Error en el constructor", 500);
        }
    }

    public function handleRequest()
    {
        try {
            $request = json_decode(file_get_contents('php://input'), true);

            if (!isset($request["action"]) || $request["action"] !== "listall") {
                ResponseMiddleware::error("Acción no permitida", 403);
                return;
            }

            $decodedToken = $this->authService->validateToken($this->getAuthorizationHeader());

            AuthorizationMiddleware::checkRolePermission($decodedToken->data->role, ['ADMIN', 'Super Usuario']);

            $response = $this->getBuquesService->getBuques();

            $buques = $response->getBuques();
            $result = [];
            foreach ($buques as $buque) {
                $result[] = [
                    'id' => $buque->getId(),
                    'codigo' => $buque->getCodigo(),
                    'nombre' => $buque->getNombre(),
                    'recaladas' => $buque->getTotalRecaladas(),
                    'atenciones' => $buque->getTotalAtenciones(),
                ];
            }

            ResponseMiddleware::success($result);
        } catch (\Exception $e) {
            $this->logError($e);
            ResponseMiddleware::error("Error en el servidor", 500);
        }
    }

    private function getAuthorizationHeader()
    {
        try {
            $headers = apache_request_headers();
            $authHeader = $headers['Authorization'] ?? '';

            if (!$authHeader) {
                throw new \Exception("Token de autorización no proporcionado.");
            }
            return $authHeader;
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    private function logError(\Exception $e)
    {
        error_log("[ERROR] " . $e->getMessage() . " en " . $e->getFile() . " línea " . $e->getLine());
    }
}
