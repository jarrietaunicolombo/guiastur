<?php

namespace Api\Controllers\Buques;

use Api\Middleware\Response\ResponseMiddleware;
use Api\Services\Buques\BuqueService;
use Exception;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Buques/BuqueService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Response/ResponseMiddleware.php";

class GetBuqueByIdMobileController {
    private $buqueService;

    public function __construct() {
        $this->buqueService = new BuqueService();
    }

    public function handleRequest($id) {
        try {
            if (!is_numeric($id) || $id <= 0) {
                throw new Exception("ID de buque inválido.");
            }

            $buque = $this->buqueService->getBuqueById($id);
            if (!$buque) {
                throw new Exception("Buque no encontrado.");
            }

            ResponseMiddleware::success(["data" => $buque]);
        } catch (Exception $e) {
            error_log("[GetBuqueByIdMobileController] Error: " . $e->getMessage());
            ResponseMiddleware::error($e->getMessage(), 404);
        }
    }
}
