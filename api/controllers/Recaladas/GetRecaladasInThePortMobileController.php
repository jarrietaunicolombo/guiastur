<?php

namespace Api\Controllers\Recaladas;

use Api\Middleware\Authorization\AuthorizationMiddleware;
use Api\Middleware\Response\ResponseMiddleware;
use Api\Services\Auth\AuthService;
use Api\Services\Recaladas\RecaladaService;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Recaladas/RecaladaService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Auth/AuthService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Response/ResponseMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Authorization/AuthorizationMiddleware.php";

class GetRecaladasInThePortMobileController {
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
            
            $response = $this->recaladaService->findRecaladasInThePort();
            ResponseMiddleware::success(json_encode($response));
        } catch (\Exception $e) {
            ResponseMiddleware::error($e->getMessage(), 400);
        }
    }

    private function getAuthorizationHeader() {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            throw new \Exception("No se ha proporcionado un token de autorización.");
        }
        return $_SERVER['HTTP_AUTHORIZATION'];
    }
}