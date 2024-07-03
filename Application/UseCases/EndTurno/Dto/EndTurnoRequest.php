<?php

class EndTurnoRequest
{
    private $turnoId;
    private $usuarioIdUso;

    public function __construct(int $turnoId, int $usuarioIdUso)
    {
        if ($turnoId === NULL || $usuarioIdUso < 1) {
            throw new InvalidArgumentException("El Id del turno es requerido para Finalizar el Turno");
        }

        if ($usuarioIdUso === NULL || $usuarioIdUso < 1) {
            throw new InvalidArgumentException("El Id Usuario que libera es requerido para Finalizar el Turno");
        }
        $this->turnoId = $turnoId;
        $this->usuarioIdUso = $usuarioIdUso;
    }

    public function getTurnoId(): int{
        return $this->turnoId;
    }

    public function getUsuarioIdUso(): int{
        return $this->usuarioIdUso;
    }
}