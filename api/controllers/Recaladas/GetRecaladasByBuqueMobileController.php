<?php

namespace Api\Controllers\Recaladas;

use Api\Middleware\Response\ResponseMiddleware;
use Api\Helpers\JWTHandler;
use Api\Exceptions\UnauthorizedException;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/JWTHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Exceptions/UnauthorizedException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetRecaladasByBuque/Dto/GetRecaladasByBuqueRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/UseCases/IGetRecaladasByBuqueService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Response/ResponseMiddleware.php";

class GetRecaladasByBuqueMobileController
{
    private $getRecaladasByBuqueService;

    public function __construct(\IGetRecaladasByBuqueService $getRecaladasByBuqueService)
    {
        $this->getRecaladasByBuqueService = $getRecaladasByBuqueService;
    }

    public function handleRequest($request)
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] !== "GET") {
                throw new \InvalidArgumentException("Método no permitido.");
            }

            $headers = apache_request_headers();
            $authHeader = $headers['Authorization'] ?? '';
            if (!$authHeader) {
                throw new UnauthorizedException("Token de autorización faltante.");
            }

            $jwtHandler = new JWTHandler();
            $userData = $jwtHandler->validateToken($authHeader);

            $buqueId = $request["buque"] ?? null;
            if (!$buqueId) {
                throw new \InvalidArgumentException("ID del buque faltante.");
            }

            $getRecaladasRequest = new \GetRecaladasByBuqueRequest($buqueId);

            $response = $this->getRecaladasByBuqueService->getRecaladasByBuque($getRecaladasRequest);

            ResponseMiddleware::success([
                "message" => "Recaladas obtenidas correctamente.",
                "data" => $response
            ]);
        } catch (UnauthorizedException $e) {
            ResponseMiddleware::error($e->getMessage(), 401);
        } catch (\Exception $e) {
            ResponseMiddleware::error($e->getMessage(), 400);
        }
    }
}
