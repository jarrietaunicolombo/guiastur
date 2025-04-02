<?php

namespace Api\Controllers\Turnos;

use Api\Middleware\Authorization\AuthorizationMiddleware;
use Api\Middleware\Response\ResponseMiddleware;
use Api\Middleware\Request\RequestMiddleware;
use Api\Services\Auth\AuthService;
use Api\Services\Turnos\TurnoService;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Turnos/TurnoService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Auth/AuthService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Request/RequestMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Authorization/AuthorizationMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Response/ResponseMiddleware.php";

class CreateTurnoMobileController {
    private $turnoService;
    private $authService;

    public function __construct() {
        $this->turnoService = new TurnoService();
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

            $this->createTurno($request, $decodedToken->data->userId);
        } catch (\Exception $e) {
            ResponseMiddleware::error($e->getMessage(), 500);
        }
    }

    private function createTurno(array $request, $userId) {
        try {
            
            RequestMiddleware::validateCreateTurnoRequest($request);

            $data = [
                'numero' => $request['numero'] ?? null,
                'estado' => $request['estado'] ?? null,
                'observaciones' => $request['observaciones'] ?? null,
                'guia_id' => $request['guia_id'] ?? null,
                'atencion_id' => $request['atencion_id'] ?? null,
            ];

            $response = $this->turnoService->createTurno($data, $userId);

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
