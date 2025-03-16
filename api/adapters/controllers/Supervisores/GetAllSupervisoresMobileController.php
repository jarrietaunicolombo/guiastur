<?php

namespace Api\Controllers\Supervisores;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Supervisores/SupervisorService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Response/ResponseMiddleware.php";

use Api\Services\Supervisores\SupervisorService;
use Api\Middleware\Response\ResponseMiddleware;
use Exception;

class GetAllSupervisoresMobileController {
    private $supervisorService;

    public function __construct() {
        $this->supervisorService = new SupervisorService();
    }

    public function handleRequest() {
        try {
            $supervisores = $this->supervisorService->getAllSupervisores();
            
            ResponseMiddleware::success($supervisores);
        } catch (Exception $e) {
            error_log("[ERROR] " . $e->getMessage());
            ResponseMiddleware::error($e->getMessage());
        }
    }
    
}
