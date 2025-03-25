<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/domain/repositories/AtencionMobileRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/exceptions/InvalidAtencionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/exceptions/NotFoundEntryException.php";

use Api\Exceptions\InvalidAtencionException;

class AtencionService
{
    private $atencionRepository;

    public function __construct()
    {
        $this->atencionRepository = new AtencionRepository();
    }

    public function createAtencion($data)
    {

        if (!isset($data["recalada_id"]) || $data["recalada_id"] < 1) {
            throw new InvalidAtencionException("El ID de la Recalada es requerido.");
        }
        if (!isset($data["fecha_inicio"]) || !isset($data["fecha_cierre"])) {
            throw new InvalidAtencionException("Las fechas de inicio y cierre son obligatorias.");
        }
        if (!isset($data["supervisor_id"]) || $data["supervisor_id"] < 1) {
            throw new InvalidAtencionException("El supervisor es obligatorio.");
        }

        $fechaInicio = DateTime::createFromFormat("Y-m-d H:i:s", $data["fecha_inicio"]);
        $fechaCierre = DateTime::createFromFormat("Y-m-d H:i:s", $data["fecha_cierre"]);


        if (!$fechaInicio || !$fechaCierre) {
            throw new InvalidAtencionException("Las fechas deben estar en formato YYYY-MM-DD HH:MM:SS.");
        }
        if ($fechaInicio > $fechaCierre) {
            throw new InvalidAtencionException("La fecha de inicio no puede ser mayor a la fecha de cierre.");
        }


        $recalada = Recalada::find($data["recalada_id"]);
        if (!$recalada) {
            throw new NotFoundEntryException("Recalada no encontrada con ID: " . $data["recalada_id"]);
        }

        $fechaActual = new DateTime();
        if ($fechaActual > new DateTime($recalada->fecha_zarpe)) {
            throw new InvalidAtencionException("No se puede crear la atención porque la recalada ya zarpó.");
        }

        if ($fechaInicio < new DateTime($recalada->fecha_arribo)) {
            throw new InvalidAtencionException("La fecha de inicio no puede ser menor a la fecha de arribo de la recalada.");
        }
        if ($fechaCierre > new DateTime($recalada->fecha_zarpe)) {
            throw new InvalidAtencionException("La fecha de cierre no puede ser mayor a la fecha de zarpe de la recalada.");
        }

        $this->atencionRepository->validateNoCollision($data["recalada_id"], $fechaInicio, $fechaCierre);

        $atencion = Atencion::create($data);

        if (!$atencion || !$atencion->id) {
            throw new Exception("No se pudo crear la atención.");
        }

        return [
            "id" => $atencion->id,
            "recalada_id" => $atencion->recalada_id,
            "fecha_inicio" => $fechaInicio->format("Y-m-d H:i:s"),
            "fecha_cierre" => $fechaCierre->format("Y-m-d H:i:s"),
            "supervisor_id" => $atencion->supervisor_id,
            "observaciones" => $atencion->observaciones
        ];
    }
}
