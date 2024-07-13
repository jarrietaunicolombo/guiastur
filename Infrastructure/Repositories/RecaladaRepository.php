<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Recalada.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IRecaladaRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/DuplicateEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/NotFoundEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Repositories/Utility.php";

class RecaladaRepository implements IRecaladaRepository
{
    public function find(int $id): Recalada
    {
        try {
            return Recalada::find($id);
        } catch (Exception $e) {
            $resul = Utility::getNotFoundRecordInfo($e->getMessage());
            if (count($resul) > 0) {
                $message = "No existe un " . $resul[UtilConstantsEnum::TABLE_NAME]
                    . " con ID: " . $resul[UtilConstantsEnum::COLUMN_VALUE];
                throw new NotFoundEntryException($message);
            }
            throw Utility::errorHandler($e);
        }
    }

    public function findAll(): array
    {
        try {
            return Recalada::all();
        } catch (Exception $e) {
            throw Utility::errorHandler($e);
        }
    }

    public function create(Recalada $recalada): Recalada
    {
        try {
            $recalada->save();
            return $recalada;
        } catch (Exception $e) {
            $resul = Utility::getDuplicateRecordInfo($e->getMessage());
            if (count($resul) > 0) {
                $message = "Recalada ya existe: " . $resul[UtilConstantsEnum::COLUMN_NAME]
                    . ": " . $resul[UtilConstantsEnum::COLUMN_VALUE];
                throw new DuplicateEntryException($message);
            }
            throw Utility::errorHandler($e);
        }
    }

    public function update(Recalada $recalada): Recalada
    {
        $this->find($recalada->id);
        try {
            $recalada->save();
            return $recalada;
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
            $recalada = $this->find($id);
            return $recalada->delete();
        } catch (Exception $e) {
            $resul = Utility::getNotFoundRecordInfo($e->getMessage());
            if (count($resul) > 0) {
                $message = "No existe un " . $resul[UtilConstantsEnum::TABLE_NAME] . " con ID: " . $resul[UtilConstantsEnum::COLUMN_VALUE];
                throw new NotFoundEntryException($message);
            }
            throw Utility::errorHandler($e);
        }
    }

    public function validateRecalada(int $buqueId, DateTime $fecha): bool
    {
        try {
            $recaladas = Recalada::find(
                "all",
                array(
                    "conditions"
                    => array(
                            "buque_id = ? AND fecha_zarpe > ?",
                            $buqueId,
                            $fecha
                        )
                )
            );
            if (count($recaladas) > 0) {
                return false;
            }
            return true;
        } catch (Exception $e) {
            throw Utility::errorHandler($e);
        }
    }

    public function findRecaladaInThePort(): array
    {
        $nowDate = new DateTime();
        try {
            $recaladas = Recalada::find(
                "all",
                array(
                    "conditions"
                    => array(
                            "fecha_arribo <= ? AND fecha_zarpe >= ?",
                            $nowDate,
                            $nowDate
                        )
                )
            );
            return $recaladas;
        } catch (Exception $e) {
            throw Utility::errorHandler($e);
        }
    }
}
