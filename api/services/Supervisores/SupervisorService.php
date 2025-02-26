<?php

namespace Api\Services\Supervisores;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/repositories/SupervisorMobileRepository.php";

use Exception;
use Api\Repositories\SupervisorMobileRepository;

class SupervisorService {
    private $supervisorRepository;

    public function __construct() {
        $this->supervisorRepository = new SupervisorMobileRepository();
    }

    /**
     * Crear un nuevo supervisor
     */
    public function createSupervisor($cedula, $nombre, $apellido, $usuarioId) {
        $this->validateSupervisorData($cedula, $nombre, $apellido);
    
        return $this->supervisorRepository->create(
            $cedula,
            $nombre,
            $apellido,
            $usuarioId
        );
    }
    
    /**
     * Obtener todos los supervisores
     */
    public function getAllSupervisores() {
        $supervisores = $this->supervisorRepository->findAll();
        return $supervisores;
    }
    

    /**
     * Obtener un supervisor por cédula
     */
    public function getSupervisorByCedula($cedula) {
        $this->validateCedula($cedula);
    
        $supervisor = $this->supervisorRepository->findByCedula($cedula);
        
    
        return $supervisor ? [
            "cedula" => $supervisor->cedula,
            "nombre" => $supervisor->nombres,
            "apellido" => $supervisor->apellidos,
            "telefono" => $supervisor->telefono
        ] : null;
    }
    
    /**
     * Eliminar un supervisor por cédula
     */
    public function deleteSupervisor($cedula) {
        $this->validateCedula($cedula);
        $this->supervisorRepository->delete($cedula);
    }

    /**
     * Validar datos de supervisor
     */
    private function validateSupervisorData($cedula, $nombre, $apellido) {
        if (!isset($cedula) || empty($cedula)) {
            throw new Exception("La cédula es inválida o está vacía.");
        }
        if (!isset($nombre) || empty($nombre)) {
            throw new Exception("El nombre del supervisor es obligatorio.");
        }
        if (!isset($apellido) || empty($apellido)) {
            throw new Exception("El apellido del supervisor es obligatorio.");
        }
    }

    /**
     * Validar una cédula
     */
    private function validateCedula($cedula) {
        if (!isset($cedula) || empty($cedula)) {
            throw new Exception("La cédula proporcionada no es válida.");
        }
    }
}