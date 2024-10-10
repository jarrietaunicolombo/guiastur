<?php

namespace Api\Controllers\Buques;

use Api\Services\Auth\AuthService;
use Api\Middleware\Response\ResponseMiddleware;
use Api\Middleware\Authorization\AuthorizationMiddleware;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Auth/AuthService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Authorization/AuthorizationMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Response/ResponseMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";

class GetBuquesMobileControllerApi
{
    private $authService;
    private $getBuquesService;

    public function __construct()
    {
        try {
            error_log("[GetBuquesMobileControllerApi] Constructor iniciado");
            $this->authService = new AuthService();
            $this->getBuquesService = \DependencyInjection::getBuquesService();
            error_log("[GetBuquesMobileControllerApi] Constructor completado");
        } catch (\Exception $e) {
            $this->logError($e);
            ResponseMiddleware::error("Error en el constructor", 500);
        }
    }

    public function handleRequest()
    {
        try {
            error_log("[GetBuquesMobileControllerApi] handleRequest iniciado");
            $request = json_decode(file_get_contents('php://input'), true);
            error_log("[GetBuquesMobileControllerApi] Request recibido: " . json_encode($request));

            if (!isset($request["action"]) || $request["action"] !== "listall") {
                error_log("[GetBuquesMobileControllerApi] Acción no permitida: " . $request["action"]);
                ResponseMiddleware::error("Acción no permitida", 403);
                return;
            }

            $decodedToken = $this->authService->validateToken($this->getAuthorizationHeader());
            error_log("[GetBuquesMobileControllerApi] Token validado correctamente");

            AuthorizationMiddleware::checkRolePermission($decodedToken->data->role, ['ADMIN', 'Super Usuario']);
            error_log("[GetBuquesMobileControllerApi] Permisos validados correctamente");

            $response = $this->getBuquesService->getBuques();
            error_log("[GetBuquesMobileControllerApi] Servicio getBuques ejecutado");

            $buques = $response->getBuques();
            $result = [];
            foreach ($buques as $buque) {
                $result[] = [
                    'id' => $buque->getId(),
                    'codigo' => $buque->getCodigo(),
                    'nombre' => $buque->getNombre(),
                    'recaladas' => $buque->getTotalRecaladas(),
                    'atenciones' => $buque->getTotalAtenciones(),
                ];
            }

            error_log("[GetBuquesMobileControllerApi] Respuesta generada: " . json_encode($result));
            ResponseMiddleware::success($result);
        } catch (\Exception $e) {
            $this->logError($e);
            ResponseMiddleware::error("Error en el servidor", 500);
        }
    }

    private function getAuthorizationHeader()
    {
        try {
            $headers = apache_request_headers();
            $authHeader = $headers['Authorization'] ?? '';
            error_log("[GetBuquesMobileControllerApi] Authorization header: " . $authHeader);

            if (!$authHeader) {
                throw new \Exception("Token de autorización no proporcionado.");
            }
            return $authHeader;
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    private function logError(\Exception $e)
    {
        error_log("[ERROR] " . $e->getMessage() . " en " . $e->getFile() . " línea " . $e->getLine());
    }
}
