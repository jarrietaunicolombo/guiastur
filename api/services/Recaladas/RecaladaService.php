<?php

namespace Api\Services\Recaladas;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/repositories/RecaladaMobileRepository.php";

use Exception;
use Api\Repositories\RecaladaMobileRepository;

class RecaladaService {
    private $recaladaRepository;

    public function __construct() {
        $this->recaladaRepository = new RecaladaMobileRepository();
    }

    /**
     * Crear una nueva recalada
     */
    public function createRecalada($buqueId, $paisId, $fechaArribo, $fechaZarpe, $totalTuristas, $observaciones, $usuarioRegistro) {
        $this->validateRecaladaData($buqueId, $fechaArribo);
    
        return $this->recaladaRepository->create(
            $buqueId,
            $paisId,
            $fechaArribo,
            $fechaZarpe,
            $totalTuristas,
            $observaciones,
            $usuarioRegistro
        );
    }
    
    /**
     * Obtener todas las recaladas
     */
    public function getAllRecaladas() {
        $recalada = $this->recaladaRepository->findAll();
        error_log("Recaladas: " . json_encode($recalada));
        return $recalada;
    }

    /**
     * Obtener una recalada por ID
     */
    public function getRecaladaById($id) {
        $this->validateId($id);
        return $this->recaladaRepository->findById($id);
    }

    /**
     * Obtener recaladas por buque
     */
    public function getRecaladasByBuque($buqueId) {
        $this->validateId($buqueId);
        return $this->recaladaRepository->findByBuque($buqueId);
    }

    /**
     * Validar si los datos de una recalada son correctos
     */
    private function validateRecaladaData($buqueId, $fecha) {
        if (!isset($buqueId) || $buqueId <= 0) {
            throw new Exception("El ID del buque es inválido.");
        }
        if (!isset($fecha)) {
            throw new Exception("La fecha de la recalada es requerida.");
        }
    }

    /**
     * Validar un ID
     */
    public function findRecaladasInThePort() {
        try {
            return $this->recaladaRepository->findRecaladaInThePort();
        } catch (\Exception $e) {
            throw new \Exception("Error al obtener recaladas en el puerto: " . $e->getMessage());
        }
    }

    /**
     * Validar un ID
     */
    private function validateId($id) {
        if (!isset($id) || $id <= 0) {
            throw new Exception("El ID proporcionado no es válido.");
        }
    }
}