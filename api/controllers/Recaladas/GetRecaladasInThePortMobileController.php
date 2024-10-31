<?php

namespace Api\Controllers\Recaladas;

use Api\Middleware\Authorization\AuthorizationMiddleware;
use Api\Middleware\Response\ResponseMiddleware;
use Api\Services\Auth\AuthService;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Auth/AuthService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetRecaladasInThePort/Dto/GetRecaladasInThePortResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetRecaladasInThePort/GetRecaladasInThePortUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";

class GetRecaladasInThePortMobileController
{
    private $getRecaladasInThePortService;
    private $authService;

    public function __construct()
    {
        $this->getRecaladasInThePortService = \DependencyInjection::getRecaladasInThePortServce();
        if (!$this->getRecaladasInThePortService){
            throw new \Exception("No se pudo cargar el servicio de recaladas en el puerto.");
        }

        $this->authService = new AuthService();
    }

    public function handleRequest(array $request){
        try {
            $authHeader = $this->getAuthorizationHeader();
            $decodedToken = $this->authService->validateToken($authHeader);

            AuthorizationMiddleware::checkRolePermission($decodedToken->data->role, ['ADMIN', 'Super Usuario']);

            $response = $this->getRecaladasInThePortService->getRecaladasInThePort();

            ResponseMiddleware::success($response);
        } catch (\Exception $e) {
            ResponseMiddleware::error(['error' => $e->getMessage()], 400);
        }
    }

    private function getAuthorizationHeader()
    {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            throw new \Exception("No se ha proporcionado un token de autorización.");
        }
        return $_SERVER['HTTP_AUTHORIZATION'];
    }
}
