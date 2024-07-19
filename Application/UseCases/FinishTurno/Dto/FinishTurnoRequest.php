<?php

class FinishTurnoRequest
{
    private $turnoId;
    private $usuarioIdUso;

    private $observaciones;

    public function __construct(int $turnoId, int $usuarioIdUso, string $observaciones = null)
    {
        if ($turnoId === null || $usuarioIdUso < 1) {
            throw new InvalidArgumentException("El Id del turno es requerido para Finalizar el Turno");
        }

        if ($usuarioIdUso === null || $usuarioIdUso < 1) {
            throw new InvalidArgumentException("El Id Usuario que libera es requerido para Finalizar el Turno");
        }
        $this->turnoId = $turnoId;
        $this->usuarioIdUso = $usuarioIdUso;
        $this->observaciones = $observaciones;
    }

    public function getTurnoId(): int{
        return $this->turnoId;
    }

    public function getUsuarioIdUso(): int{
        return $this->usuarioIdUso;
    }

    public function getObservaciones(){
        return $this->observaciones;
    }
}