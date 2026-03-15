<?php

namespace Api\Controllers\Paises;

use Api\Middleware\Response\ResponseMiddleware;
use Api\Services\Paises\PaisService;
use Exception;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Paises/PaisService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Response/ResponseMiddleware.php";

class GetPaisByIdMobileController {
    private $paisService;

    public function __construct() {
        $this->paisService = new PaisService();
    }

    public function handleRequest($id) {
        try {
            if (!is_numeric($id) || $id <= 0) {
                throw new Exception("ID de país inválido.");
            }

            $pais = $this->paisService->getPaisById($id);
            if (!$pais) {
                throw new Exception("País no encontrado.");
            }

            ResponseMiddleware::success(["data" => $pais]);
        } catch (Exception $e) {
            ResponseMiddleware::error($e->getMessage(), 404);
        }
    }
}
