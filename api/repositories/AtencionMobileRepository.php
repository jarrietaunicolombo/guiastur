<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Atencion.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Recalada.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Exceptions/NotFoundEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Exceptions/DuplicateEntryException.php";

use Api\Exceptions\NotFoundEntryException;
use Api\Exceptions\DuplicateEntryException;

class AtencionRepository
{
    public function find(int $id)
    {
        try {
            return Atencion::find($id);
        } catch (Exception $e) {
            throw new NotFoundEntryException("Atención no encontrada con ID: $id");
        }
    }

    public function findAll()
    {
        try {
            return Atencion::all();
        } catch (Exception $e) {
            throw new Exception("Error al obtener las atenciones");
        }
    }

    public function create(array $data)
    {
        try {
            return Atencion::create($data);
        } catch (Exception $e) {
            throw new DuplicateEntryException("La atención ya existe o hay un error en la creación.");
        }
    }

    public function update(Atencion $atencion)
    {
        try {
            $this->find($atencion->id);
            $atencion->save();
            return $atencion;
        } catch (Exception $e) {
            throw new Exception("Error al actualizar la atención");
        }
    }

    public function delete(int $id)
    {
        try {
            $atencion = $this->find($id);
            return $atencion->delete();
        } catch (Exception $e) {
            throw new NotFoundEntryException("No se puede eliminar, atención no encontrada con ID: $id");
        }
    }
}
