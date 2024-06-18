<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Pais.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IPaisRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/DuplicateEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/NotFoundEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/Utility.php";

class PaisRepository implements IPaisRepository
{
    public function find($id): Pais
    {
        try {
            return Pais::find($id);
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
            return Pais::all();
        } catch (Exception $e) {
            throw Utility::errorHandler($e);
        }
    }

    public function create(Pais $Pais): Pais
    {
        try {
            $Pais->save();
            return $Pais;
        } catch (Exception $e) {
            $resul = Utility::getDuplicateRecordInfo($e->getMessage());
            if (count($resul) > 0) {
                $message = "Pais ya existe: " . $resul[UtilConstantsEnum::COLUMN_NAME] . ": " . $resul[UtilConstantsEnum::COLUMN_VALUE];
                throw new DuplicateEntryException($message);
            }
            throw Utility::errorHandler($e);
        }
    }

    public function update(Pais $Pais): Pais
    {
        $this->find($Pais->id);
        try {
            $Pais->save();
            return $Pais;
        } catch (Exception $e) {
            $resul = Utility::getDuplicateRecordInfo($e->getMessage());
            if (count($resul) > 0) {
                $message = "Pais ya existe: " . $resul[UtilConstantsEnum::COLUMN_NAME] . ": " . $resul[UtilConstantsEnum::COLUMN_VALUE];
                throw new DuplicateEntryException($message);
            }
            throw Utility::errorHandler($e);
        }
    }

    public function delete($id): bool
    {
        $Pais = $this->find($id);
        return $Pais->delete();
    }
}
