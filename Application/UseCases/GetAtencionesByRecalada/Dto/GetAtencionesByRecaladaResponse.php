<?php

class GetAtencionesByRecaladaResponse
{
    private $buque;
    private $recalada;
    private $atenciones;

    public function __construct(BuqueResponse $buque = null, RecaladaResponse $recalada  = null, array $atenciones = array())
    {
        $this->buque = $buque;
        $this->recalada = $recalada;
        $this->atenciones = $atenciones;
    }

    public function getBuque(): BuqueResponse
    {
        return $this->buque;
    }

    public function getRecalada(): RecaladaResponse
    {
        return $this->recalada;
    }

    public function getAtenciones(): array
    {
        return $this->atenciones;
    }
}



class BuqueResponse {
    private $id;
    private $nombre;

    public function __construct(int $id, string $nombre)  {
        if ($id < 1) {
            throw new \InvalidArgumentException("El Bueque Id es requerido para Obtener Atenciones Por Recalada");
        }

        if ($nombre == null || empty(trim($nombre))) {
            throw new \InvalidArgumentException("El nombre del buque es requerido para Obtener Atenciones Por Recalada");
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



class RecaladaResponse {
    private $id;
    private $pais;

    public function __construct(int $id, string $pais)
    {
        if ($id < 1) {
            throw new \InvalidArgumentException("El ID de recalada es requerido para Obtener Atenciones Por Recalada");
        }

        if ($pais == null || empty(trim($pais))) {
            throw new \InvalidArgumentException("El país es requerido para Obtener Atenciones Por Recalada");
        }

        $this->id = $id;
        $this->pais = $pais;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getPais(): string {
        return $this->pais;
    }
}





class AtencionResponse {
    private $id;
    private $fecha_inicio;
    private $fecha_cierre;
    private $total_turnos;
    private $total_turnos_creados;
    private $turnos_disponibles;
    private $observaciones;
    private $supervisor_id;
    private $supervisor_nombre;

    public function __construct(
        int $id,
        DateTime $fecha_inicio,
        DateTime $fecha_cierre,
        int $total_turnos = 0,
        int $total_turnos_creados = 0,
        int $turnos_disponibles = 0,
        string $observaciones = null,
        string $supervisor_id = null,
        string $supervisor_nombre = null
    ) {
        if ($id < 1) {
            throw new \InvalidArgumentException("El ID de la atención es requerido para Obtener Atenciones Por Recalada");
        }

        if ($fecha_inicio === null) {
            throw new \InvalidArgumentException("La fecha de inicio de la atención es requerida para Obtener Atenciones Por Recalada");
        }

        if ($fecha_cierre === null) {
            throw new \InvalidArgumentException("La fecha de cierre de la atención es requerida para Obtener Atenciones Por Recalada");
        }

        $this->id = $id;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_cierre = $fecha_cierre;
        $this->total_turnos = $total_turnos;
        $this->total_turnos_creados = $total_turnos_creados;
        $this->turnos_disponibles = $turnos_disponibles;
        $this->observaciones = $observaciones;
        $this->supervisor_id = $supervisor_id;
        $this->supervisor_nombre = $supervisor_nombre;
    }

    public function getId(): int {
        return $this->id;
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
