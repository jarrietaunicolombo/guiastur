<?php

namespace Api\Controllers\Buques;

use Api\Middleware\Authorization\AuthorizationMiddleware;
use Api\Middleware\Response\ResponseMiddleware;
use Api\Middleware\Request\RequestMiddleware;
use Api\Services\Auth\AuthService;
use Api\Services\Buques\BuqueService;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Buques/BuqueService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Auth/AuthService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Request/RequestMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Authorization/AuthorizationMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Response/ResponseMiddleware.php";

class CreateBuqueMobileController {
    private $buqueService;
    private $authService;

    public function __construct() {
        $this->buqueService = new BuqueService();
        $this->authService = new AuthService();
    }

    public function handleRequest(array $request) {
        try {
            error_log("[CreateBuqueMobileController] Iniciando handleRequest");
            error_log("[CreateBuqueMobileController] Request recibido: " . json_encode($request));

            if (!isset($request["action"]) || $request["action"] !== "create") {
                error_log("[CreateBuqueMobileController] Acción no permitida");
                ResponseMiddleware::error("Acción no permitida", 403);
                exit();
            }

            error_log("[CreateBuqueMobileController] Acción válida: " . $request["action"]);

            $authHeader = $this->getAuthorizationHeader();
            error_log("[CreateBuqueMobileController] Token recibido: " . substr($authHeader, 0, 20) . "...");

            $decodedToken = $this->authService->validateToken($authHeader);
            error_log("[CreateBuqueMobileController] Token validado correctamente");

            AuthorizationMiddleware::checkRolePermission($decodedToken->data->role, ['ADMIN', 'Super Usuario']);
            error_log("[CreateBuqueMobileController] Permisos validados correctamente");

            $this->createBuque($request, $decodedToken->data->userId);
        } catch (\Exception $e) {
            error_log("[CreateBuqueMobileController] Error en handleRequest: " . $e->getMessage());
            ResponseMiddleware::error($e->getMessage(), 500);
        }
    }

    private function createBuque(array $request, $userId) {
        try {
            RequestMiddleware::validateCreateBuqueRequest($request);

            $response = $this->buqueService->createBuque(
                $request['nombre'],
                $request['codigo'],
                $userId
            );
            

            ResponseMiddleware::success(json_encode($response));
        } catch (\Exception $e) {
            ResponseMiddleware::error($e->getMessage(), 500);
        }
    }

    private function getAuthorizationHeader() {
        $headers = apache_request_headers();
        error_log("[CreateBuqueMobileController] Headers recibidos: " . json_encode($headers));

        $authHeader = $headers['Authorization'] ?? '';
        if (!$authHeader) {
            error_log("[CreateBuqueMobileController] Error: Token de autorización no proporcionado");
            throw new \Exception("Token de autorización no proporcionado.");
        }
        return $authHeader;
    }
}
