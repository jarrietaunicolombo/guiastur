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
        error_log("AuthService inicializado correctamente.");
    }

    public function handleRequest(array $request)
    {
        try {
            // Logging de la solicitud recibida
            error_log("Solicitud recibida en handleRequest: " . print_r($request, true));

            if ($request["action"] !== "create") {
                error_log("Acción no permitida: " . $request["action"]);
                ResponseMiddleware::error("Acción no permitida", 403);
            }

            // Validar token JWT
            $authHeader = $this->getAuthorizationHeader();
            error_log("Token JWT obtenido: " . $authHeader);

            $decodedToken = $this->authService->validateToken($authHeader);
            error_log("Token JWT decodificado: " . print_r($decodedToken, true));

            // Verificación de permisos de usuario
            AuthorizationMiddleware::checkRolePermission($decodedToken->data->role, ['ADMIN', 'Super Usuario']);
            error_log("Permisos validados para el rol: " . $decodedToken->data->role);

            // Llamar a la función para crear la recalada
            $this->createRecalada($request, $decodedToken->data->userId);
        } catch (\Exception $e) {
            $error = ["error" => $e->getMessage()];
            error_log("Error capturado en handleRequest: " . $e->getMessage());
            echo json_encode($error);
            exit;
        }
    }

    private function createRecalada(array $request, $userId)
    {
        // Loggeamos los datos recibidos
        error_log("Datos recibidos en createRecalada: " . print_r($request, true));

        try {
            RequestMiddleware::validateCreateRecaladaRequest($request);
            error_log("Validación de la solicitud pasada con éxito.");
        } catch (\Exception $e) {
            // Log detallado del error con trace y origen
            error_log("Error en la validación de la solicitud en archivo: " . $e->getFile() . " en la línea: " . $e->getLine());
            error_log("Mensaje de error: " . $e->getMessage());
            error_log("Trace del error: " . $e->getTraceAsString());
            throw $e;
        }

        try {
            // Conversión y validación de fechas
            error_log("Convirtiendo fechas...");
            $fecha_arribo = \DateTime::createFromFormat('Y-m-d\TH:i', $request['fecha_arribo']);
            $fecha_zarpe = isset($request['fecha_zarpe']) ? \DateTime::createFromFormat('Y-m-d\TH:i', $request['fecha_zarpe']) : null;

            if ($fecha_arribo === false) {
                error_log("Formato de fecha de arribo inválido.");
                throw new \Exception("Formato de fecha de arribo inválido.");
            }

            if ($fecha_zarpe !== null && $fecha_zarpe === false) {
                error_log("Formato de fecha de zarpe inválido.");
                throw new \Exception("Formato de fecha de zarpe inválido.");
            }

            // Loggeamos las fechas
            error_log("Fecha Arribo: " . $fecha_arribo->format('Y-m-d H:i'));
            error_log("Fecha Zarpe: " . ($fecha_zarpe ? $fecha_zarpe->format('Y-m-d H:i') : 'Sin fecha de zarpe'));

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
            error_log("Datos preparados para el servicio: " . print_r($createRecaladaRequest, true));

            // Llamar al servicio
            error_log("Llamando al servicio CreateRecalada...");
            $response = $this->createRecaladaService->CreateRecalada($createRecaladaRequest);

            if (!$response) {
                error_log("Respuesta nula o inválida del servicio CreateRecalada.");
                throw new \Exception("No se pudo crear la recalada. El servicio no devolvió una respuesta válida.");
            }

            error_log("Respuesta del servicio: " . print_r($response, true));
            ResponseMiddleware::success($response->toJSON());
        } catch (\Exception $e) {
            // Log detallado del error con trace y origen
            error_log("Error en createRecalada en archivo: " . $e->getFile() . " en la línea: " . $e->getLine());
            error_log("Mensaje de error: " . $e->getMessage());
            error_log("Trace del error: " . $e->getTraceAsString());
            ResponseMiddleware::error($e->getMessage(), 500);
        }
    }

    private function getAuthorizationHeader()
    {
        $headers = apache_request_headers();
        error_log("Encabezados de la solicitud: " . print_r($headers, true));

        $authHeader = $headers['Authorization'] ?? '';
        if (!$authHeader) {
            error_log("Token de autorización no proporcionado.");
            throw new \Exception("Token de autorización no proporcionado.");
        }
        return $authHeader;
    }
}
