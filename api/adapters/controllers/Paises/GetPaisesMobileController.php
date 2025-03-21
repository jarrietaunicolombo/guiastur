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
        $this->paisService = new PaisService();
    }

    public function handleRequest() {
        try {
            $response = $this->paisService->getAllPaises();
    
            ResponseMiddleware::success($response);
        } catch (Exception $e) {
            ResponseMiddleware::error($e->getMessage(), 500);
        }
    }
    
}
