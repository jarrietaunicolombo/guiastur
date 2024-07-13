<?php

class ReleaseTurnoRequest
{
    private $turnoId;
    private $usuarioIdUso;

    public function __construct(int $turnoId, int $usuarioIdUso)
    {
        if ($turnoId === null || $usuarioIdUso < 1) {
            throw new InvalidArgumentException("El Id del turno es requerido para Liberare el Turno");
        }

        if ($usuarioIdUso === null || $usuarioIdUso < 1) {
            throw new InvalidArgumentException("El Id Usuario que libera es requerido para Liberare el Turno");
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