<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Authorization/AuthorizationMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateAtencion/Dto/CreateAtencionRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Request/RequestMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Response/ResponseMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/JWTHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";

use Api\Middleware\Authorization\AuthorizationMiddleware;
use Api\Middleware\Request\RequestMiddleware;
use Api\Middleware\Response\ResponseMiddleware;
use Api\Services\Auth\AuthService;


class CreateAtencionMobileController
{
    private $createAtencionService;
    private $authService;


    public function __construct()
    {
        $this->createAtencionService = DependencyInjection::getCreateAtencionService();
        $this->authService = new AuthService();
    }

    public function handleRequest(array $request)
    {
        if ($request['action'] !== 'create') {
            ResponseMiddleware::error('Invalid action', 403);
        }

        $authToken = $_COOKIE['auth_token'] ?? '';
        $decodedToken = $this->authService->validateToken($authToken);
        AuthorizationMiddleware::checkRolePermission($decodedToken->role, ['ADMIN', 'USER']);

        RequestMiddleware::validateCreateAtencionRequest($request);

        try {
            $fechaInicio = new DateTime($request['fecha_inicio']);
            $fechaCierre = isset($request['fecha_cierre']) ? new DateTime($request['fecha_cierre']) : null;

            if (!isset($request['total_turnos'])) {
                throw new InvalidArgumentException("El campo 'total_turnos' es obligatorio.");
            }

            $createAtencionRequest = new CreateAtencionRequest(
                $fechaInicio,
                $fechaCierre,
                $request['total_turnos'],
                $request['observaciones'] ?? null,
                $request['supervisor_id'] ?? null,
                $request['recalada_id'],
                $decodedToken->userId
            );

            $response = $this->createAtencionService->createAtencion($createAtencionRequest);
            ResponseMiddleware::success($response->toJSON());

        } catch (Exception $e) {
            ResponseMiddleware::error($e->getMessage(), 500);
        }
    }
}
