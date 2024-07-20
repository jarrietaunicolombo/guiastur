<?php
class ValidateAtencionRequest
{
    private $recaladaId;
    private $fechaInicio;
    private $fechaCierre;

    public function __construct(int $recaladaId, DateTime $fechaInicio, DateTime $fechaCierre)
    {
        if (!isset($recaladaId) || $recaladaId < 1) {
            throw new InvalidArgumentException("El ID de la Recalada es requerido para validar la nueva Atencion");
        }

        if (!isset($fechaInicio)) {
            throw new InvalidArgumentException("La Fecha de inicio es requerida para validar la nueva Atencion");
        }

        if (!isset($fechaCierre)) {
            throw new InvalidArgumentException("La Fecha de ceirre es requerida para validar la nueva Atencion");
        }

        if($fechaInicio > $fechaCierre){
            throw new InvalidArgumentException("Fecha de inicio no puede ser mayor a la Fecha de cierre al validar la nueva Atencion");
        }


        $this->recaladaId = $recaladaId;
        $this->fechaInicio = $fechaInicio;
        $this->fechaCierre = $fechaCierre;
    }

    public function getRecaladaId(): int{
        return $this->recaladaId;
    }

    public function getFechaInicio(): DateTime{
        return $this->fechaInicio;
    }

    public function getFechaCierre(): DateTime{
        return $this->fechaCierre;
    }

    
}