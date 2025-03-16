<?php

namespace Api\Repositories;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Supervisor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/NotFoundEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/DuplicateEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/Utility.php";

use Exception;

class SupervisorMobileRepository {
    /**
     * Buscar supervisor por cédula
     */
    public function findByCedula($cedula) {
        try {
            $supervisor = \Supervisor::find($cedula);
    
            if (!$supervisor) {
                error_log("[DEBUG] Supervisor no encontrado en BD.");
                return null;
            }
    
    
            return $supervisor;
        } catch (Exception $e) {
            throw \Utility::errorHandler($e);
        }
    }
    

    /**
     * Obtener todos los supervisores
     */
    public function findAll() {
        try {
            $supervisores = \Supervisor::all();
            
            if (empty($supervisores)) {
                return [];
            }
    
            $data = [];
            foreach ($supervisores as $supervisor) {
                $data[] = [
                    'cedula' => $supervisor->cedula,
                    'nombre' => $supervisor->nombres,
                    'apellido' => $supervisor->apellidos,
                    'telefono' => $supervisor->telefono
                ];
            }
            
            return $data;
    
        } catch (Exception $e) {
            throw \Utility::errorHandler($e);
        }
    }
    
    
    
    /**
     * Crear un supervisor
     */
    public function create($cedula, $nombres, $apellidos, $usuarioId) {
        try {
            $supervisor = \Supervisor::create([
                "cedula" => $cedula,
                "nombre" => $nombres,
                "apellido" => $apellidos,
                "usuario_id" => $usuarioId
            ]);
            
            if (!$supervisor) {
                throw new \Exception("No se pudo crear el supervisor.");
            }
    
    
            return $supervisor->to_array();
        } catch (Exception $e) {
            throw \Utility::errorHandler($e);
        }
    }
    
    /**
     * Eliminar un supervisor por cédula
     */
    public function delete($cedula) {
        try {
            $supervisor = $this->findByCedula($cedula);
            if (!$supervisor) {
                throw new \NotFoundEntryException("Supervisor no encontrado.");
            }
            
            $supervisor->delete();
        } catch (Exception $e) {
            throw \Utility::errorHandler($e);
        }
    }
}
