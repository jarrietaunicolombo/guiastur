<?php
class ValidateAtencionRequest
{
    private $recaladaId;
    private $fecha;

    public function __construct(int $recaladaId, DateTime $fecha)
    {
        if (!isset($recaladaId) || $recaladaId <= 0) {
            throw new \InvalidArgumentException("La RecaladaId es requerido para validar na nueva Atencion");
        }

        if (!isset($fecha)) {
            throw new \InvalidArgumentException("La Fecha de inicio es requerida para validar la nueva Atencion");
        }
        $this->recaladaId = $recaladaId;
        $this->fecha = $fecha;
    }

    public function getRecaladaId(): int{
        return $this->recaladaId;
    }

    public function getFecha(): DateTime{
        return $this->fecha;
    }
    
}