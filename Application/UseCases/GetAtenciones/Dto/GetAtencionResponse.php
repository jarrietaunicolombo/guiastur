<?php
require_once $_SERVER["DOCUMENT_ROOT"]. "/guiastur/Application/UseCases/GenericDto.php";
class GetAtencionResponse extends GenericDto
{
    
    private $atencionId;
    private $fecha_inicio;
    private $fecha_cierre;
    private $total_turnos;
    private $total_turnos_creados;
    private $turnos_disponibles;
    private $observaciones;
    private $supervisor_id;
    private $supervisor_nombre;
    private $buque;
    private $recalada;

    public function __construct(  
        int $atencionid,
        DateTime $fecha_inicio,
        DateTime $fecha_cierre,
        int $total_turnos = 0,
        int $total_turnos_creados = 0,
        int $turnos_disponibles = 0,
        string $observaciones = null,
        string $supervisor_id = null,
        string $supervisor_nombre = null,
        BuqueResponseDto $buque = null, 
        RecaladaResponseDto $recalada  = null 
    ) {
        if ($atencionid < 1) {
            throw new InvalidArgumentException("El ID de la atención es requerido para Obtener Atenciones por Id");
        }

        if ($fecha_inicio === null) {
            throw new InvalidArgumentException("La fecha de inicio de la atención es requerida para Obtener Atenciones por Id");
        }

        if ($fecha_cierre === null) {
            throw new InvalidArgumentException("La fecha de cierre de la atención es requerida para Obtener Atenciones por Id");
        }

        if ($total_turnos < 1) {
            throw new InvalidArgumentException("El total de turnos es requerido para Obtener Atenciones por Id");
        }

        $this->atencionId = $atencionid;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_cierre = $fecha_cierre;
        $this->total_turnos = $total_turnos;
        $this->total_turnos_creados = $total_turnos_creados;
        $this->turnos_disponibles = $turnos_disponibles;
        $this->observaciones = $observaciones;
        $this->supervisor_id = $supervisor_id;
        $this->supervisor_nombre = $supervisor_nombre;
        $this->buque = $buque;
        $this->recalada = $recalada;
    }

    public function getBuque(): BuqueResponseDto
    {
        return $this->buque;
    }

    public function getRecalada(): RecaladaResponseDto
    {
        return $this->recalada;
    }
    
    public function getAtencionId(): int {
        return $this->atencionId;
    }

    public function getFechaInicio() : DateTime {
        return $this->fecha_inicio;
    }

    public function getFechaCierre() : DateTime {
        return $this->fecha_cierre;
    }

    public function getTotalTurnos(): int {
        return $this->total_turnos;
    }

    public function getTotalTurnosCreados(): int {
        return $this->total_turnos_creados;
    }

    public function getTurnosDisponibles(): int {
        return $this->turnos_disponibles;
    }

    public function getObservaciones() {
        return $this->observaciones;
    }

    public function getSupervisorId() : string {
        return $this->supervisor_id;
    }
    public function getSupervisorNombre() : string {
        return $this->supervisor_nombre;
    }
}



class BuqueResponseDto {
    private $id;
    private $nombre;

    public function __construct(int $id, string $nombre)  {
        if ($id < 1) {
            throw new InvalidArgumentException("El Bueque Id es requerido para Obtener Atencion por Id");
        }

        if ($nombre == null || empty(trim($nombre))) {
            throw new InvalidArgumentException("El nombre del buque es requerido para Obtener Atencion por Id");
        }
        $this->id = $id;
        $this->nombre = $nombre;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }
}



class RecaladaResponseDto {
    private $id;
    private $pais;
    private $fecha_arribo;
    private $fecha_zarpe;

    public function __construct(int $id, DateTime $fecha_arribo, DateTime $fecha_zarpe, string $pais)
    {
        if ($id < 1) {
            throw new InvalidArgumentException("El ID de recalada es requerido para Obtener Atenciones por Id");
        }

         if ($fecha_arribo === null ) {
            throw new InvalidArgumentException("La fecha de arribo de la recalada es requerido para Obtener Atenciones por Id");
        }

        if ($fecha_zarpe === null ) {
            throw new InvalidArgumentException("La fecha de zarpe de la recalada es requerido para Obtener Atenciones por Id");
        }

        if ($pais == null || empty(trim($pais))) {
            throw new InvalidArgumentException("El país es requerido para Obtener Atenciones por Id");
        }

        $this->id = $id;
        $this->pais = $pais;
        $this->fecha_arribo = $fecha_arribo;
        $this->fecha_zarpe = $fecha_zarpe;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getPais(): string {
        return $this->pais;
    }

    public function getFechaArribo() : DateTime
    {
        return $this->fecha_arribo;
    }

    public function getFechaZarpe() : DateTime
    {
        return $this->fecha_zarpe;
    }
}



