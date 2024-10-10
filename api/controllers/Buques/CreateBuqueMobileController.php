<?php

namespace Api\Controllers\Buques;

use Api\Services\Auth\AuthService;
use Api\Middleware\Request\RequestMiddleware;
use Api\Middleware\Response\ResponseMiddleware;
use Api\Middleware\Authorization\AuthorizationMiddleware;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Auth/AuthService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Authorization/AuthorizationMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Request/RequestMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Response/ResponseMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateBuque/Dto/CreateBuqueRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateBuque/CreateBuqueUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";

class CreateBuqueMobileController
{
    private $createBuqueService;
    private $authService;

    public function __construct()
    {
        try {
            error_log("[CreateBuqueMobileController] Constructor iniciado");
            $this->createBuqueService = \DependencyInjection::getCreateBuqueServce();
            $this->authService = new AuthService();
            error_log("[CreateBuqueMobileController] Constructor completado");
        } catch (\Exception $e) {
            $this->logError($e);
            ResponseMiddleware::error("Error en el constructor", 500);
        }
    }

    public function handleRequest(array $request)
    {
        try {
            error_log("[CreateBuqueMobileController] handleRequest iniciado");
            error_log("[CreateBuqueMobileController] Request recibido: " . json_encode($request));

            if ($request["action"] !== "create") {
                error_log("[CreateBuqueMobileController] Acción no permitida: " . $request["action"]);
                ResponseMiddleware::error("Acción no permitida", 403);
            }

            $decodedToken = $this->authService->validateToken($this->getAuthorizationHeader());
            error_log("[CreateBuqueMobileController] Token validado correctamente");

            AuthorizationMiddleware::checkRolePermission($decodedToken->data->role, ['ADMIN', 'Super Usuario']);
            error_log("[CreateBuqueMobileController] Permisos validados correctamente");

            RequestMiddleware::validateCreateBuqueRequest($request);
            error_log("[CreateBuqueMobileController] Request validado correctamente");

            $createRequest = new \CreateBuqueRequest($request['codigo'], $request['nombre'], null, $decodedToken->data->userId);
            $response = $this->createBuqueService->CreateBuque($createRequest);
            error_log("[CreateBuqueMobileController] Servicio createBuque ejecutado");

            ResponseMiddleware::success($response->toJSON());
        } catch (\InvalidArgumentException $e) {
            error_log("[CreateBuqueMobileController] Error de validación: " . $e->getMessage());
            ResponseMiddleware::error($e->getMessage(), 400);
        } catch (\Exception $e) {
            $this->logError($e);
            ResponseMiddleware::error("Error interno del servidor", 500);
        }
    }

    private function getAuthorizationHeader()
    {
        try {
            $headers = apache_request_headers();
            $authHeader = $headers['Authorization'] ?? '';
            error_log("[CreateBuqueMobileController] Authorization header: " . $authHeader);

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
