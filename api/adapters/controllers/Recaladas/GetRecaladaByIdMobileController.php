<?php

namespace Api\Controllers\Recaladas;

use Api\Middleware\Authorization\AuthorizationMiddleware;
use Api\Middleware\Response\ResponseMiddleware;
use Api\Services\Auth\AuthService;
use Api\Services\Recaladas\RecaladaService;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Recaladas/RecaladaService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Auth/AuthService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Response/ResponseMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Authorization/AuthorizationMiddleware.php";

class GetRecaladaByIdMobileController {
    private $recaladaService;
    private $authService;

    public function __construct() {
        $this->recaladaService = new RecaladaService();
        $this->authService = new AuthService();
    }

    public function handleRequest(array $request) {
        try {
            // Validar token de autorización
            $authHeader = $this->getAuthorizationHeader();
            $decodedToken = $this->authService->validateToken($authHeader);
            AuthorizationMiddleware::checkRolePermission($decodedToken->data->role, ['ADMIN', 'Super Usuario']);

            // Validar que el ID esté presente
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                ResponseMiddleware::error("ID de recalada no proporcionado.", 400);
                return;
            }

            $id = (int) $_GET['id'];

            // Obtener la recalada por ID
            $this->getRecaladaById($id);
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

    private function getRecaladaById($id) {
        try {
            $recalada = $this->recaladaService->getRecaladaById($id);

            if (!$recalada || empty($recalada)) {
                ResponseMiddleware::error("Recalada no encontrada.", 404);
                return;
            }

            ResponseMiddleware::success(['recalada' => $recalada]);
        } catch (\Exception $e) {
            ResponseMiddleware::error($e->getMessage(), 500);
        }
    }
}
