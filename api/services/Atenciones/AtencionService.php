<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/repositories/AtencionMobileRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/exceptions/InvalidAtencionException.php";

class AtencionService
{
    private $atencionRepository;

    public function __construct()
    {
        $this->atencionRepository = new AtencionRepository();
    }

    public function createAtencion($data)
    {
        try {
            $atencion = Atencion::create($data);
    
            // Verificar si se creó correctamente
            if (!$atencion || !$atencion->id) {
                throw new Exception("No se pudo crear la atención.");
            }
    
            return [
                "id" => $atencion->id,
                "recalada_id" => $atencion->recalada_id,
                "fecha_inicio" => $atencion->fecha_inicio instanceof DateTime ? $atencion->fecha_inicio->format("Y-m-d H:i:s") : $atencion->fecha_inicio,
                "fecha_cierre" => $atencion->fecha_cierre instanceof DateTime ? $atencion->fecha_cierre->format("Y-m-d H:i:s") : $atencion->fecha_cierre,
                "supervisor_id" => $atencion->supervisor_id,
                "observaciones" => $atencion->observaciones
            ];
        } catch (Exception $e) {
            throw new Exception("Error al crear la atención: " . $e->getMessage());
        }
    }
}
