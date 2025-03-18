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
    
        // Verificar si la consulta se ejecutó correctamente
        if (!isset($resultado["data"]) || !is_array($resultado["data"])) {
            error_log("[PaisService] Error: Resultado inválido de la base de datos");
            return ["status" => "error", "message" => "Error al obtener los países"];
        }
    
        error_log("[PaisService] Países recibidos desde el repositorio: " . json_encode($resultado["data"]));
    
        return [
            "status" => "success",
            "total" => count($resultado["data"]),
            "data" => $resultado["data"]
        ];
    }
    
}
