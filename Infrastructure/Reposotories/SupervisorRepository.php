<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Supervisor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/ISupervisorRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/DuplicateEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/NotFoundEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/Utility.php";

class SupervisorRepository implements ISupervisorRepository
{
    public function find($id): Supervisor
    {
        try {
            return Supervisor::find($id);
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
            return Supervisor::all();
        } catch (Exception $e) {
            throw Utility::errorHandler($e);
        }
    }

    public function create(Supervisor $supervisor): Supervisor
    {
        try {
            $supervisor->save();
            return $supervisor;
        } catch (Exception $e) {
            $resul = Utility::getDuplicateRecordInfo($e->getMessage());
            if (count($resul) > 0) {
                $message = "Supervisor ya existe: " . $resul[UtilConstantsEnum::COLUMN_NAME] . ": " . $resul[UtilConstantsEnum::COLUMN_VALUE];
                throw new DuplicateEntryException($message);
            }
            throw Utility::errorHandler($e);
        }
    }

    public function update(Supervisor $supervisor)
    {
        $this->find($supervisor->id);
        try {
            $supervisor->save();
        } catch (Exception $e) {
            $resul = Utility::getDuplicateRecordInfo($e->getMessage());
            if (count($resul) > 0) {
                $message = "No existe un " . $resul[UtilConstantsEnum::TABLE_NAME] . " con ID: " . $resul[UtilConstantsEnum::COLUMN_VALUE];
                throw new NotFoundEntryException($message);
            }
            throw Utility::errorHandler($e);
        }
    }

    public function delete($id)
    {
        try {
            $supervisor = $this->find($id);
            $supervisor->delete();
        } catch (Exception $e) {
            $resul = Utility::getDuplicateRecordInfo($e->getMessage());
            if (count($resul) > 0) {
                $message = "No existe un " . $resul[UtilConstantsEnum::TABLE_NAME] . " con ID: " . $resul[UtilConstantsEnum::COLUMN_VALUE];
                throw new NotFoundEntryException($message);
            }
            throw Utility::errorHandler($e);
        }
    }
}
