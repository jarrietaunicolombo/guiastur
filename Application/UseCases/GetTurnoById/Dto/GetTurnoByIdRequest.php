<?php

class GetTurnoByIdRequest
{
    private $turnoId;
    public function __construct(int $turnoId)
    {
        if ($turnoId === NULL || $turnoId < 1) {
            throw new InvalidArgumentException("El Id del turno es requerido para Liberare el Turno");
        }
        $this->turnoId = $turnoId;

    }

    public function getTurnoId(): int{
        return $this->turnoId;
    }
}