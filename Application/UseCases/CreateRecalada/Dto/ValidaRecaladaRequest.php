<?php
class ValidateRecaldaRequest
{
    private $buqueId;
    private $fecha;

    public function __construct(int $buqueId, DateTime $fecha)
    {
        if (!isset($buqueId) || $buqueId <= 0) {
            throw new \InvalidArgumentException("El BuqueId es requerido para validar na nueva Recalda");
        }

        if (!isset($fecha)) {
            throw new \InvalidArgumentException("La fecha de inicio es requerida para validar la nueva Recalada");
        }
        $this->buqueId = $buqueId;
        $this->fecha = $fecha;
    }

    public function getBuqueId(): int{
        return $this->buqueId;
    }

    public function getFecha(): DateTime{
        return $this->fecha;
    }
    
}