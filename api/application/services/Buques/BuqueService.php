<?php

namespace Api\Services\Buques;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/domain/repositories/BuqueMobileRepository.php";

use Exception;
use Api\Repositories\BuqueMobileRepository;

class BuqueService {
    private $buqueRepository;

    public function __construct() {
        $this->buqueRepository = new BuqueMobileRepository();
    }

    /**
     * Crear un nuevo buque
     */
    public function createBuque($nombre, $codigo, $usuarioRegistro) {
        $this->validateBuqueData($nombre, $codigo);
        return $this->buqueRepository->create($nombre, $codigo, $usuarioRegistro);
    }

    /**
     * Obtener todos los buques
     */
    public function getAllBuques() {
        $buques = $this->buqueRepository->findAll();
        error_log("Buques: " . json_encode($buques));
        return $buques;
    }

    /**
     * Obtener un buque por ID
     */
    public function getBuqueById($id) {
        $this->validateId($id);
        return $this->buqueRepository->findById($id);
    }

    /**
     * Validar si los datos del buque son correctos
     */
    private function validateBuqueData($nombre, $tipo) {
        if (empty($nombre)) {
            throw new Exception("El nombre del buque es requerido.");
        }
        if (empty($tipo)) {
            throw new Exception("El tipo de buque es requerido.");
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
