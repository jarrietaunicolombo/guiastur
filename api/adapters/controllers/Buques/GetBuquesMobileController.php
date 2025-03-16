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

class GetBuquesMobileController {
    private $buqueService;
    private $authService;

    public function __construct() {
        $this->buqueService = new BuqueService();
        $this->authService = new AuthService();
    }

    public function handleRequest() {
        try {

            $authHeader = $this->getAuthorizationHeader();

            $decodedToken = $this->authService->validateToken($authHeader);

            AuthorizationMiddleware::checkRolePermission($decodedToken->data->role, ['ADMIN', 'Super Usuario', 'Usuario']);

            $response = $this->buqueService->getAllBuques();
            ResponseMiddleware::success($response);
        } catch (\Exception $e) {
            error_log("[GetBuquesMobileController] Error en handleRequest: " . $e->getMessage());
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