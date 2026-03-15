<?php

namespace Api\Domain\Repositories\Turnos;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Turno.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/NotFoundEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/DuplicateEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/Utility.php";

use Exception;

class TurnoMobileRepository {
    /**
     * Buscar turno por ID
     */
    public function findById($id) {
        try {
            return \Turno::find($id);
        } catch (Exception $e) {
            throw \Utility::errorHandler($e);
        }
    }

    /**
     * Crear un nuevo turno
     */
    public function create($data) {
        try {
            $turno = \Turno::create($data);
            if (!$turno) {
                throw new \Exception("No se pudo crear el turno.");
            }
            return $turno->to_array();
        } catch (Exception $e) {
            throw \Utility::errorHandler($e);
        }
    }

    /**
     * Actualizar un turno existente
     */
    public function update($turno) {
        try {
            if (!$turno->save()) {
                throw new \Exception("No se pudo actualizar el turno.");
            }
            return $turno->to_array();
        } catch (Exception $e) {
            throw \Utility::errorHandler($e);
        }
    }

    /**
     * Obtener los turnos por atención
     */
    public function findByAtencion($atencionId) {
        try {
            return \Turno::where('atencion_id', $atencionId)->get();
        } catch (Exception $e) {
            throw \Utility::errorHandler($e);
        }
    }
}
