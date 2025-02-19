<?php

namespace Api\Controllers\Recaladas;

use Api\Middleware\Authorization\AuthorizationMiddleware;
use Api\Middleware\Response\ResponseMiddleware;
use Api\Middleware\Request\RequestMiddleware;
use Api\Services\Auth\AuthService;
use Api\Services\Recaladas\RecaladaService;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Recaladas/RecaladaService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Auth/AuthService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Request/RequestMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Authorization/AuthorizationMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Response/ResponseMiddleware.php";

class CreateRecaladaMobileController {
    private $recaladaService;
    private $authService;

    public function __construct() {
        $this->recaladaService = new RecaladaService();
        $this->authService = new AuthService();
    }

    public function handleRequest(array $request) {
        try {
            error_log("[CreateRecaladaMobileController] Iniciando handleRequest");
    
            // 🔹 Log para ver qué datos están llegando
            error_log("[CreateRecaladaMobileController] Request recibido: " . json_encode($request));
    
            if (!isset($request["action"]) || $request["action"] !== "create") {
                error_log("[CreateRecaladaMobileController] Acción no permitida");
                ResponseMiddleware::error("Acción no permitida", 403);
                exit();
            }
            
            error_log("[CreateRecaladaMobileController] Acción válida: " . $request["action"]);
            
            // Obtener el token de autorización
            $authHeader = $this->getAuthorizationHeader();
            error_log("[CreateRecaladaMobileController] Token recibido: " . substr($authHeader, 0, 20) . "...");
    
            $decodedToken = $this->authService->validateToken($authHeader);
            error_log("[CreateRecaladaMobileController] Token validado correctamente");
    
            AuthorizationMiddleware::checkRolePermission($decodedToken->data->role, ['ADMIN', 'Super Usuario']);
            error_log("[CreateRecaladaMobileController] Permisos validados correctamente");
    
            $this->createRecalada($request, $decodedToken->data->userId);
        } catch (\Exception $e) {
            error_log("[CreateRecaladaMobileController] Error en handleRequest: " . $e->getMessage());
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
    
            error_log("[CreateRecaladaMobileController] Datos a enviar:");
            error_log("Fecha Arribo: " . $fecha_arribo->format('Y-m-d H:i:s'));
            error_log("Fecha Zarpe: " . ($fecha_zarpe ? $fecha_zarpe->format('Y-m-d H:i:s') : "NULL"));
    
            $response = $this->recaladaService->createRecalada(
                $request['buque_id'],
                $request['pais_id'],
                $fecha_arribo,
                $fecha_zarpe, // ✅ Pasamos la fecha de zarpe correctamente
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
        error_log("[CreateRecaladaMobileController] Headers recibidos: " . json_encode($headers));

        $authHeader = $headers['Authorization'] ?? '';
        if (!$authHeader) {
            error_log("[CreateRecaladaMobileController] Error: Token de autorización no proporcionado");
            throw new \Exception("Token de autorización no proporcionado.");
        }
        return $authHeader;
    }
}
