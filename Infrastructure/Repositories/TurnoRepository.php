<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Constants/TurnoStatusEnum.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Turno.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/ITurnoRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/DuplicateEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/NotFoundEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Repositories/Utility.php";

class TurnoRepository implements ITurnoRepository
{
    public function find(int $id): Turno
    {
        try {
            return Turno::find($id);
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
            return Turno::all();
        } catch (Exception $e) {
            throw Utility::errorHandler($e);
        }
    }

    public function create(Turno $Turno): Turno
    {
        try {
            $Turno->save();
            return $Turno;
        } catch (Exception $e) {
            $resul = Utility::getDuplicateRecordInfo($e->getMessage());
            if (count($resul) > 0) {
                $message = "Turno ya existe: " . $resul[UtilConstantsEnum::COLUMN_NAME] . ": " . $resul[UtilConstantsEnum::COLUMN_VALUE];
                throw new DuplicateEntryException($message);
            }
            throw Utility::errorHandler($e);
        }
    }

    public function update(Turno $Turno): Turno
    {
        $this->find($Turno->id);
        try {
            $Turno->save();
            return $Turno;
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
            $Turno = $this->find($id);
            return $Turno->delete();
        } catch (Exception $e) {
            $resul = Utility::getNotFoundRecordInfo($e->getMessage());
            if (count($resul) > 0) {
                $message = "No existe un " . $resul[UtilConstantsEnum::TABLE_NAME] . " con ID: " . $resul[UtilConstantsEnum::COLUMN_VALUE];
                throw new NotFoundEntryException($message);
            }
            throw Utility::errorHandler($e);
        }
    }

    public function findByAtencion(int $atencionId): array
    {
        $turnos = Turno::find("all", ["conditions" => ["atencion_id = ?", $atencionId]]);
        return $turnos;
    }

    public function findWithStateCreatedByAtencion(int $atencionId): array
    {
        try {
            $status = TurnoStatusEnum::CREATED;
            $turnos = Turno::find(
                "all",
                array(
                    "conditions"
                    => array(
                            "estado = ? AND atencion_id = ?",
                            $status,
                            $atencionId
                        )
                )
            );
            return $turnos;
        } catch (Exception $e) {
            throw Utility::errorHandler($e);
        }
    }

    public function findNexTurno(int $atencionId): Turno
    {
        try {
            $estado = TurnoStatusEnum::CREATED;
            $turno = Turno::find(
                "first",
                array(
                    "conditions" =>
                        array(
                            "atencion_id = ? AND estado = ? AND fecha_uso is ?"
                            ,
                            $atencionId,
                            $estado,
                            null
                        )
                )
            );
            if (!isset($turno)) {
                throw new NotFoundEntryException("No existen turnos disponibles para la Atención Id: $atencionId");
            }
            return $turno;
        } catch (Exception $e) {
            $resul = Utility::getNotFoundRecordInfo($e->getMessage());
            if (count($resul) > 0) {
                $message = "No existe un " . $resul[UtilConstantsEnum::TABLE_NAME] . " con ID: " . $resul[UtilConstantsEnum::COLUMN_VALUE];
                throw new NotFoundEntryException($message);
            }
            throw Utility::errorHandler($e);
        }
    }

    public function findAllNextTurnosByState(string $turnoStatus): array
    {
        try {
            $fecha = (new DateTime())->format('Y-m-d');
            $atenciones = Atencion::find("all", array("conditions" => array("Date(fecha_inicio) = ?", $fecha)));
            if (!isset($atenciones) ||  count($atenciones) == 0) {
                throw new NotFoundEntryException("No existen atenciones programadas para hoy");
            }
            if (!in_array($turnoStatus, TurnoStatusEnum::getConstansValues())) {
                throw new InvalidArgumentException("No existen Turnos en estado $turnoStatus, el estado incorrecto");
            }
            $quantity = "all";
            if($turnoStatus == TurnoStatusEnum::CREATED){
                $quantity = "first";
            }
            $turnos = null;
            
            foreach ($atenciones as $atencion) {
                $turnos = Turno::find(
                    $quantity,
                    array(
                        "conditions" =>
                            array(
                                "atencion_id = ? AND estado = ?",
                                $atencion->id,
                                $turnoStatus
                            )
                    )
                );
                if (isset($turnos) && !is_array($turnos)) {
                    $turnos  = array($turnos);
                    break;
                }
            }
            return $turnos ?? array();
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
