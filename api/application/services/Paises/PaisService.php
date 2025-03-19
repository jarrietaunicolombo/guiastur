<?php

namespace Api\Services\Paises;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/domain/repositories/PaisMobileRepository.php";

use Api\Repositories\PaisMobileRepository;
use Exception;

class PaisService {
    private $paisRepository;

    public function __construct() {
        error_log("[PaisService] Constructor llamado");
        $this->paisRepository = new PaisMobileRepository();
    }

    /**
     * Obtener todos los países
     */
    public function getAllPaises() {
        error_log("[PaisService] getAllPaises() llamado");
    
        $resultado = $this->paisRepository->findAll();
    
        if (!isset($resultado["data"]) || !is_array($resultado["data"])) {
            return ["status" => "error", "message" => "Error al obtener los países"];
        }
    
        return [
            "status" => "success",
            "total" => count($resultado["data"]),
            "data" => $resultado["data"]
        ];
    }

    /**
     * Obtener un país por su ID
     */
    public function getPaisById($id) {
        error_log("[PaisService] getPaisById() llamado con ID: " . $id);

        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("ID de país inválido.");
        }

        return $this->paisRepository->findById($id);
    }
}
