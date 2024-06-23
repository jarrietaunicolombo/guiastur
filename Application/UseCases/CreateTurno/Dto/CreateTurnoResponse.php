<?php
require_once __DIR__ . "/CreateTurnoRequest.php";
class CreateTurnoResponse
{
    private $id;
    private $turno;

    public function __construct(int $id, CreateTurnoRequest $turno){
        if ($id === NULL || $id <= 0) {
            throw new InvalidArgumentException("El Id del Turno es requerido al crear un nuevo Turno");
        }

        if ($turno === NULL) {
            throw new InvalidArgumentException("Los datos del Turno son requeridos al ser creado");
        }

        $this->id = $id;
        $this->turno = $turno;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTurno(): CreateTurnoRequest
    {
        return $this->turno;
    }

}
