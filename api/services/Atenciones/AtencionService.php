<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/repositories/AtencionMobileRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/exceptions/InvalidAtencionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/exceptions/NotFoundEntryException.php";

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
        error_log("📌 Datos recibidos en createAtencion: " . json_encode($data));

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

        error_log("📌 Validando fechas: Inicio - {$data["fecha_inicio"]}, Cierre - {$data["fecha_cierre"]}");

        if (!$fechaInicio || !$fechaCierre) {
            throw new InvalidAtencionException("Las fechas deben estar en formato YYYY-MM-DD HH:MM:SS.");
        }
        if ($fechaInicio > $fechaCierre) {
            throw new InvalidAtencionException("La fecha de inicio no puede ser mayor a la fecha de cierre.");
        }

        error_log("📌 Buscando recalada con ID: " . $data["recalada_id"]);

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

        error_log("📌 Validando colisión de horarios...");
        $this->atencionRepository->validateNoCollision($data["recalada_id"], $fechaInicio, $fechaCierre);

        error_log("📌 Creando la atención...");
        $atencion = Atencion::create($data);

        if (!$atencion || !$atencion->id) {
            throw new Exception("No se pudo crear la atención.");
        }

        error_log("✅ Atención creada con éxito - ID: " . $atencion->id);

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
