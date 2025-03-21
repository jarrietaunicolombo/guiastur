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

            if (!isset($request["action"]) || $request["action"] !== "create") {
                ResponseMiddleware::error("Acción no permitida", 403);
                exit();
            }
            
            $authHeader = $this->getAuthorizationHeader();

            $decodedToken = $this->authService->validateToken($authHeader);

            AuthorizationMiddleware::checkRolePermission($decodedToken->data->role, ['ADMIN', 'Super Usuario']);

            $this->createRecalada($request, $decodedToken->data->userId);
        } catch (\Exception $e) {
            ResponseMiddleware::error($e->getMessage(), 500);
        }
    }

    private function createRecalada(array $request, $userId) {
        try {

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

            ResponseMiddleware::success(json_encode($response));
        } catch (\Exception $e) {
            ResponseMiddleware::error($e->getMessage(), 500);
        }
    }

    private function getAuthorizationHeader() {
        $headers = apache_request_headers();

        $authHeader = $headers['Authorization'] ?? '';
        if (!$authHeader) {
            throw new \Exception("Token de autorización no proporcionado.");
        }
        return $authHeader;
    }
}
