<?php

namespace Api\Controllers\Recaladas;

use Api\Middleware\Authorization\AuthorizationMiddleware;
use Api\Middleware\Response\ResponseMiddleware;
use Api\Services\Auth\AuthService;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Auth/AuthService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetRecaladasByBuque/Dto/GetRecaladasByBuqueRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Response/ResponseMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Authorization/AuthorizationMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";

class GetRecaladasByBuqueController
{
    private $getRecaladasByBuqueService;
    private $authService;

    public function __construct()
    {
        $this->getRecaladasByBuqueService = \DependencyInjection::getRecaladasByBuqueService();
        if (!$this->getRecaladasByBuqueService) {
            throw new \Exception("No se pudo cargar el servicio de recaladas por buque.");
        }

        $this->authService = new AuthService();
    }

    public function handleRequest(array $request)
    {
        try {
            $authHeader = $this->getAuthorizationHeader();
            $decodedToken = $this->authService->validateToken($authHeader);

            AuthorizationMiddleware::checkRolePermission($decodedToken->data->role, ['ADMIN', 'Super Usuario']);

            if (!isset($request['buque_id']) || !is_numeric($request['buque_id'])) {
                ResponseMiddleware::error("ID de buque no proporcionado o no válido", 400);
            }

            $buqueId = (int)$request['buque_id'];

            $recaladasRequest = new \GetRecaladasByBuqueRequest($buqueId);

            $recaladas = $this->getRecaladasByBuqueService->getRecaladasByBuque($recaladasRequest);

            ResponseMiddleware::success($recaladas);

        } catch (\InvalidArgumentException $e) {
            ResponseMiddleware::error("Solicitud no válida: " . $e->getMessage(), 400);
        } catch (\Exception $e) {
            ResponseMiddleware::error("Error al obtener recaladas: " . $e->getMessage(), 500);
        }
    }

    private function getAuthorizationHeader()
    {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            throw new \Exception('Encabezado de autorización no proporcionado');
        }
        return $_SERVER['HTTP_AUTHORIZATION'];
    }
}
