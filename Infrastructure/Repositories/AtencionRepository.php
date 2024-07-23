<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Atencion.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Recalada.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IAtencionRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/DuplicateEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/NotFoundEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/InvalidRecaladaException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Repositories/Utility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IAtencionRepository.php";

class AtencionRepository implements IAtencionRepository
{
    public function find(int $id): Atencion
    {
        try {
            return Atencion::find($id); 
        } catch (Exception $e) {
            $resul = Utility::getNotFoundRecordInfo($e->getMessage());
            if (count($resul) > 0) {
                $message = "No existe un " . $resul[UtilConstantsEnum::TABLE_NAME] . " con ID: " . $resul[UtilConstantsEnum::COLUMN_VALUE];
                throw new NotFoundEntryException($message);
            }
            throw Utility::errorHandler($e);
        }
    }

    public function findAll(): array
    {
        try {
            return Atencion::all();
        } catch (Exception $e) {
            throw Utility::errorHandler($e);
        }
    }

    public function create(Atencion $Atencion): Atencion
    {
        try {
            $Atencion->save(); 
            return $Atencion;
        } catch (Exception $e) {
            $resul = Utility::getDuplicateRecordInfo($e->getMessage());
            if (count($resul) > 0) {
                $message = "Atencion ya existe: " . $resul[UtilConstantsEnum::COLUMN_NAME] . ": " . $resul[UtilConstantsEnum::COLUMN_VALUE];
                throw new DuplicateEntryException($message);
            }
            throw Utility::errorHandler($e);
        }
    }

    public function update(Atencion $Atencion): Atencion
    {
        $this->find($Atencion->id);
        try {
            $Atencion->save();
            return $Atencion;
        } catch (Exception $e) {
            $resul = Utility::getNotFoundRecordInfo($e->getMessage());
            if (count($resul) > 0) {
                $message = "No existe un " . $resul[UtilConstantsEnum::TABLE_NAME] . " con ID: " . $resul[UtilConstantsEnum::COLUMN_VALUE];
                throw new NotFoundEntryException($message);
            }
            throw Utility::errorHandler($e);
        }
    }

    public function delete(int $id): bool
    {
        try {
            $Atencion = $this->find($id);
            return $Atencion->delete(); 
        } catch (Exception $e) {
            $resul = Utility::getNotFoundRecordInfo($e->getMessage());
            if (count($resul) > 0) {
                $message = "No existe un " . $resul[UtilConstantsEnum::TABLE_NAME] . " con ID: " . $resul[UtilConstantsEnum::COLUMN_VALUE];
                throw new NotFoundEntryException($message);
            }
            throw Utility::errorHandler($e);
        }
    }

    public function validateAtencion(int $RecaladaId, DateTime $fechaInicio, DateTime $fechaCierre)
    {
        try {
            $now = new DateTime();
            $recaldad = Recalada::find(
                "first",
               [
                    "conditions" =>
                    [
                        "id = ? AND fecha_zarpe >= ?",
                        $RecaladaId, 
                        $now 
                    ]
               ]
            );
            if(!$recaldad){
                $message = "El Buque con recalda ID $RecaladaId ha Zarpado del puerto";
                throw new InvalidRecaladaException($message);
            }

            $atencion = Atencion::find(
                "first",
                [
                    "conditions" =>
                    [
                        "recalada_id = ? AND ? between fecha_inicio AND fecha_cierre", 
                        $RecaladaId, 
                        $fechaInicio]
                ]
            );
            if ($atencion) {
                $message = "La Fecha de Inicio " . $fechaInicio->format("Y-m-d H:i:s") . " se cruza con otra atencion";
                throw new InvalidAtencionException($message);
            }

            $atencion = Atencion::find(
                "first",
                [
                    "conditions" =>
                    [
                        "recalada_id = ? AND  ? between fecha_inicio AND fecha_cierre", 
                        $RecaladaId, 
                        $fechaCierre]
                ]
            );
            if ($atencion) {
                $message = "La Fecha de Cierre " . $fechaCierre->format("Y-m-d H:i:s") . " se cruza con otra atencion";
                throw new InvalidAtencionException($message);
            }
        } catch (Exception $e) {
            $resul = Utility::getNotFoundRecordInfo($e->getMessage());
            if (count($resul) > 0) {
                $message = "No existe un " . $resul[UtilConstantsEnum::TABLE_NAME] . " con ID: " . $resul[UtilConstantsEnum::COLUMN_VALUE];
                throw new NotFoundEntryException($message);
            }
            throw Utility::errorHandler($e);
        }
    }

    public function findByRecalada(int $recaladaId): array
    {
        try {
            $recalada = Recalada::find($recaladaId);
            return $recalada->atencions; 
        } catch (Exception $e) {
            $resul = Utility::getNotFoundRecordInfo($e->getMessage());
            if (count($resul) > 0) {
                $message = "No existe un " . $resul[UtilConstantsEnum::TABLE_NAME] . " con ID: " . $resul[UtilConstantsEnum::COLUMN_VALUE];
                throw new NotFoundEntryException($message);
            }
            throw Utility::errorHandler($e);
        }

    }
}
