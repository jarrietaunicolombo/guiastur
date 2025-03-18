<?php

namespace Api\Controllers\Paises;

use Api\Middleware\Response\ResponseMiddleware;
use Api\Services\Paises\PaisService;
use Exception;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Paises/PaisService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Response/ResponseMiddleware.php";

class GetPaisesMobileController {
    private $paisService;

    public function __construct() {
        error_log("[GetPaisesMobileController] Constructor llamado");
        $this->paisService = new PaisService();
    }

    public function handleRequest() {
        try {
            error_log("[GetPaisesMobileController] handleRequest() llamado");
            $response = $this->paisService->getAllPaises();
            error_log("[GetPaisesMobileController] Respuesta enviada al cliente: " . json_encode($response));
    
            ResponseMiddleware::success($response);
        } catch (Exception $e) {
            error_log("[GetPaisesMobileController] Error: " . $e->getMessage());
            ResponseMiddleware::error($e->getMessage(), 500);
        }
    }
    
}
