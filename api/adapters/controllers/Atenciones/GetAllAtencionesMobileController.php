<?php

namespace Api\Controllers\Atenciones;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Atenciones/AtencionService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Response/ResponseMiddleware.php";

use Api\Middleware\Response\ResponseMiddleware;
use Api\Services\Atenciones\AtencionService;
use Exception;

class GetAllAtencionesMobileController
{
    private $atencionService;

    public function __construct()
    {
        $this->atencionService = new AtencionService();
    }

    public function handleRequest($request)
    {
        try {
            $atenciones = $this->atencionService->getAllAtenciones();
            return ResponseMiddleware::success($atenciones, 200);
        } catch (Exception $e) {
            return ResponseMiddleware::error(["error" => $e->getMessage()], 500);
        }
    }
}
