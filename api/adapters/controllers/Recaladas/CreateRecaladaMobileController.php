<?php

namespace Api\Controllers\Recaladas;

use Api\Middleware\Authorization\AuthorizationMiddleware;
use Api\Middleware\Response\ResponseMiddleware;
use Api\Middleware\Request\RequestMiddleware;
use Api\Services\Auth\AuthService;
use Api\Services\Recaladas\RecaladaService;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Recaladas/RecaladaService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Auth/AuthService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Request/RequestMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Authorization/AuthorizationMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Response/ResponseMiddleware.php";

class CreateRecaladaMobileController {
    private $recaladaService;
    private $authService;

    public function __construct() {
        $this->recaladaService = new RecaladaService();
        $this->authService = new AuthService();
    }

    public function handleRequest(array $request) {
        try {    
            error_log("[CreateRecaladaMobileController] Request recibida: " . json_encode($request));

            if (!isset($request["action"]) || $request["action"] !== "create") {
                error_log("[CreateRecaladaMobileController] Acción no permitida.");
                ResponseMiddleware::error("Acción no permitida", 403);
                exit();
            }
            
            $authHeader = $this->getAuthorizationHeader();
            error_log("[CreateRecaladaMobileController] Token recibido: " . $authHeader);

            $decodedToken = $this->authService->validateToken($authHeader);
            error_log("[CreateRecaladaMobileController] Token decodificado: " . json_encode($decodedToken));

            AuthorizationMiddleware::checkRolePermission($decodedToken->data->role, ['ADMIN', 'Super Usuario']);

            $this->createRecalada($request, $decodedToken->data->userId);
        } catch (\Exception $e) {
            error_log("[CreateRecaladaMobileController] Error en handleRequest: " . $e->getMessage());
            ResponseMiddleware::error($e->getMessage(), 500);
        }
    }

    private function createRecalada(array $request, $userId) {
        try {
            error_log("[CreateRecaladaMobileController] Creando recalada con datos: " . json_encode($request));

            RequestMiddleware::validateCreateRecaladaRequest($request);
    
            $fecha_arribo = new \DateTime($request['fecha_arribo']);
            $fecha_zarpe = isset($request['fecha_zarpe']) ? new \DateTime($request['fecha_zarpe']) : null;
            $totalTuristas = isset($request['total_turistas']) ? (int) $request['total_turistas'] : 0;
            $observaciones = isset($request['observaciones']) ? $request['observaciones'] : "";
        
            $response = $this->recaladaService->createRecalada(
                $request['buque_id'],
                $request['pais_id'],
                $fecha_arribo,
                $fecha_zarpe,
                $totalTuristas,
                $observaciones,
                $userId
            );

            error_log("[CreateRecaladaMobileController] Recalada creada correctamente: " . json_encode($response));
            ResponseMiddleware::success(json_encode($response));
        } catch (\Exception $e) {
            error_log("[CreateRecaladaMobileController] Error en createRecalada: " . $e->getMessage());
            ResponseMiddleware::error($e->getMessage(), 500);
        }
    }

    private function getAuthorizationHeader() {
        $headers = apache_request_headers();
        error_log("[CreateRecaladaMobileController] Headers recibidos: " . json_encode($headers));

        $authHeader = $headers['Authorization'] ?? '';
        if (!$authHeader) {
            error_log("[CreateRecaladaMobileController] Error: Token de autorización no proporcionado");
            throw new \Exception("Token de autorización no proporcionado.");
        }
        return $authHeader;
    }
}
