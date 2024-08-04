<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GenericDto.php";
class GetRecaladasResponse extends GenericDto
{
    private $recaladas;

    public function __construct(array $recaladas)
    {
        if (!isset($recaladas)) {
            $recaladas = array();
        }
        $this->recaladas = $recaladas;
    }

    public function getRecaladas(): array
    {
        return $this->recaladas;
    }


}




class RecaladaResponseDto extends GenericDto
{
    private $recaladaId;
    private $buque_id;
    private $buque_nombre;
    private $fecha_arribo;
    private $fecha_zarpe;
    private $total_turistas;
    private $pais_id;
    private $pais_nombre;
    private $numero_atenciones;
    private $observaciones;

    public function __construct(
        int $recaladaId,
        int $buque_id,
        string $buque_nombre,
        DateTime $fecha_arribo,
        DateTime $fecha_zarpe,
        int $total_turistas,
        int $pais_id,
        string $pais_nombre,
        string $observaciones = null,
        int $numero_atenciones
    ) {
        // Validations...
        if ($recaladaId === null || $recaladaId <= 0) {
            throw new InvalidArgumentException("La RecaladaId es requerida para Obtener Las Recaladas En El Puerto");
        }

        if ($buque_id === null || $buque_id <= 0) {
            throw new InvalidArgumentException("El BuqueId es requerido para Obtener Las Recaladas En El Puerto");
        }

        if ($buque_nombre === null || empty(trim($buque_nombre))) {
            throw new InvalidArgumentException("El Nombre del Buque es requerido para Obtener Las Recaladas En El Puerto");
        }

        if ($fecha_arribo === null) {
            throw new InvalidArgumentException("La Fecha de Arribo es requerida para Obtener Las Recaladas En El Puerto");
        }

        if ($fecha_zarpe === null) {
            throw new InvalidArgumentException("La Fecha de Zarpe es requerida para Obtener Las Recaladas En El Puerto");
        }

        if ($total_turistas === null || $total_turistas <= 0) {
            throw new InvalidArgumentException("La Numero de Turistas  requerido para Obtener Las Recaladas En El Puerto");
        }

        if ($pais_id === null || $pais_id <= 0) {
            throw new InvalidArgumentException("El PaisId  requerido para Obtener Las Recaladas En El Puerto");
        }

        if ($pais_nombre === null || empty(trim($pais_nombre))) {
            throw new InvalidArgumentException("El Nombre del Pais es requerido para Obtener Las Recaladas En El Puerto");
        }


        $this->recaladaId = $recaladaId;
        $this->buque_id = $buque_id;
        $this->buque_nombre = $buque_nombre;
        $this->fecha_arribo = $fecha_arribo;
        $this->fecha_zarpe = $fecha_zarpe;
        $this->total_turistas = $total_turistas;
        $this->pais_id = $pais_id;
        $this->pais_nombre = $pais_nombre;
        $this->observaciones = $observaciones;
        $this->numero_atenciones = $numero_atenciones;
    }

    public function getRecaladaId(): int
    {
        return $this->recaladaId;
    }

    public function getBuqueId(): int
    {
        return $this->buque_id;
    }

    public function getBuqueNombre(): string
    {
        return $this->buque_nombre;
    }

    public function getFechaArribo(): DateTime
    {
        return $this->fecha_arribo;
    }

    public function getFechaZarpe(): DateTime
    {
        return $this->fecha_zarpe;
    }

    public function getTotalTuristas(): int
    {
        return $this->total_turistas;
    }

    public function getPaisId(): int
    {
        return $this->pais_id;
    }

    public function getPaisNombre(): string
    {
        return $this->pais_nombre;
    }

    public function getNumeroAtenciones(): int
    {
        return $this->numero_atenciones;
    }

    public function getObservaciones()
    {
        return $this->observaciones;
    }
}
