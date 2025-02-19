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

Class GetRecaladasMobileController {
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
            
            $this->getRecaladas();
        } catch (\InvalidPermissionException $e) {
            ResponseMiddleware::error($e->getMessage(), 403);
        } catch (\Exception $e) {
            ResponseMiddleware::error("Error interno del servidor", 500);
        }
    }

    private function getAuthorizationHeader() {
        $headers = apache_request_headers();
        $authHeader = $headers['Authorization'] ?? null;

        if (!$authHeader) {
            throw new \InvalidPermissionException("Token de autorización no proporcionado.");
        }
        return $authHeader;
    }

    private function getRecaladas() {
        try {
            $response = $this->recaladaService->getAllRecaladas();
            ResponseMiddleware::success(['recaladas' => $response]);
        } catch (\Exception $e) {
            ResponseMiddleware::error($e->getMessage(), 500);
        }
    }
}