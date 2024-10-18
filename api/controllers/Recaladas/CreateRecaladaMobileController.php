<?php

namespace Api\Controllers\Recaladas;

use Api\Middleware\Authorization\AuthorizationMiddleware;
use Api\Middleware\Response\ResponseMiddleware;
use Api\Middleware\Request\RequestMiddleware;
use Api\Services\Auth\AuthService;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Auth/AuthService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Request/RequestMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Authorization/AuthorizationMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Response/ResponseMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateRecalada/Dto/CreateRecaladaRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";

class CreateRecaladaMobileController
{
    private $createRecaladaService;
    private $authService;

    public function __construct()
    {
        $this->createRecaladaService = \DependencyInjection::getCreateRecaladaServce();
        if (!$this->createRecaladaService) {
            throw new \Exception("No se pudo cargar el servicio de creación de recaladas.");
        }

        $this->authService = new AuthService();
    }

    public function handleRequest(array $request)
    {
        try {
            // Logging de la solicitud recibida

            if ($request["action"] !== "create") {
                ResponseMiddleware::error("Acción no permitida", 403);
            }

            // Validar token JWT
            $authHeader = $this->getAuthorizationHeader();

            $decodedToken = $this->authService->validateToken($authHeader);

            // Verificación de permisos de usuario
            AuthorizationMiddleware::checkRolePermission($decodedToken->data->role, ['ADMIN', 'Super Usuario']);

            // Llamar a la función para crear la recalada
            $this->createRecalada($request, $decodedToken->data->userId);
        } catch (\Exception $e) {
            $error = ["error" => $e->getMessage()];
            echo json_encode($error);
            exit;
        }
    }

    private function createRecalada(array $request, $userId)
    {
        // Loggeamos los datos recibidos

        try {
            RequestMiddleware::validateCreateRecaladaRequest($request);
        } catch (\Exception $e) {
            // Log detallado del error con trace y origen
            throw $e;
        }

        try {
            // Conversión y validación de fechas
            $fecha_arribo = \DateTime::createFromFormat('Y-m-d\TH:i', $request['fecha_arribo']);
            $fecha_zarpe = isset($request['fecha_zarpe']) ? \DateTime::createFromFormat('Y-m-d\TH:i', $request['fecha_zarpe']) : null;

            if ($fecha_arribo === false) {
                throw new \Exception("Formato de fecha de arribo inválido.");
            }

            if ($fecha_zarpe !== null && $fecha_zarpe === false) {
                throw new \Exception("Formato de fecha de zarpe inválido.");
            }

            // Loggeamos las fechas

            // Crear recalada
            $createRecaladaRequest = new \CreateRecaladaRequest(
                $fecha_arribo,
                $fecha_zarpe,
                $request['total_turistas'],
                $request['observaciones'] ?? null,
                $request['buque_id'],
                $request['pais_id'],
                $userId
            );

            // Log para los datos preparados

            // Llamar al servicio
            $response = $this->createRecaladaService->CreateRecalada($createRecaladaRequest);

            if (!$response) {
                throw new \Exception("No se pudo crear la recalada. El servicio no devolvió una respuesta válida.");
            }

            ResponseMiddleware::success($response->toJSON());
        } catch (\Exception $e) {
            ResponseMiddleware::error($e->getMessage(), 500);
        }
    }

    private function getAuthorizationHeader()
    {
        $headers = apache_request_headers();

        $authHeader = $headers['Authorization'] ?? '';
        if (!$authHeader) {
            throw new \Exception("Token de autorización no proporcionado.");
        }
        return $authHeader;
    }
}
