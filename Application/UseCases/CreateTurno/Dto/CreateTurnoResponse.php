<?php
require_once __DIR__ . "/CreateTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GenericDto.php";

class CreateTurnoResponse extends GenericDto
{
    private $id;
    private $turno;

    public function __construct(int $id, CreateTurnoRequest $turno){
        if ($id === null || $id <= 0) {
            throw new InvalidArgumentException("El Id del Turno es requerido al crear un nuevo Turno");
        }

        if ($turno === null) {
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

    public function toJSON(): string{
        $tunoData = ["id"=>$this->id, "turno"=>$this->turno->toJSON()];
        return json_encode($tunoData);
    }

}
