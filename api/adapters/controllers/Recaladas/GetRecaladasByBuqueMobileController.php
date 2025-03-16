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

class GetRecaladasByBuqueMobileController {
    private $recaladaService;
    private $authService;

    public function __construct() {
        $this->recaladaService = new RecaladaService();
        $this->authService = new AuthService();
    }

    public function handleRequest(array $request) {
        try {
            $authHeader = $this->getAuthorizationHeader();
            $decodedToken = $this->authService->validateToken($authHeader);
            AuthorizationMiddleware::checkRolePermission($decodedToken->data->role, ['ADMIN', 'Super Usuario']);
            
            if (!isset($request['buque_id']) || !is_numeric($request['buque_id'])) {
                ResponseMiddleware::error("ID de buque no proporcionado o no válido", 400);
            }
            
            $buqueId = (int)$request['buque_id'];
            $recaladas = $this->recaladaService->getRecaladasByBuque($buqueId);
            
            ResponseMiddleware::success(json_encode($recaladas));
        } catch (\Exception $e) {
            ResponseMiddleware::error($e->getMessage(), 500);
        }
    }

    private function getAuthorizationHeader() {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            throw new \Exception('Encabezado de autorización no proporcionado');
        }
        return $_SERVER['HTTP_AUTHORIZATION'];
    }
}
