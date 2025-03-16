<?php

namespace Api\Controllers\Supervisores;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Supervisores/SupervisorService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Response/ResponseMiddleware.php";

use Api\Services\Supervisores\SupervisorService;
use Api\Middleware\Response\ResponseMiddleware;
use Exception;

class GetSupervisorByCedulaMobileController {
    private $supervisorService;

    public function __construct() {
        $this->supervisorService = new SupervisorService();
    }

    public function handleRequest() {
        try {
            if (!isset($_GET['cedula']) || empty(trim($_GET['cedula']))) {
                http_response_code(400);
                echo json_encode(["error" => "La cédula es requerida"]);
                exit();
            }
            $cedula = trim($_GET['cedula']);
            
            $supervisor = $this->supervisorService->getSupervisorByCedula($cedula);
            
            if (!$supervisor) {
                throw new Exception("No se encontró el supervisor con la cédula proporcionada.");
            }
    
            ResponseMiddleware::success(["supervisor" => $supervisor]);
        } catch (Exception $e) {
            error_log("[ERROR] " . $e->getMessage());
            ResponseMiddleware::error($e->getMessage());
        }
    }
    
    
}