<?php
require_once $_SERVER["DOCUMENT_ROOT"]."guiastur/Application/UseCases/GenericDto.php";
class UseTurnoResponse extends GenericDto
{
   
    private $id;
    private $numero;
    private $estado;
    private $fecha_uso;
    private $usuario_uso;
   
    public function __construct(
        int $id,
        int $numero,
        string $estado,
        DateTime $fecha_uso = null,
        int $usuario_uso = null
    ) {
        if ($id === null || $id < 1) {
            throw new InvalidArgumentException("El ID del Turno es requerido para Usar el Turno");
        }
      
        if ($numero === null || $numero < 1) {
            throw new InvalidArgumentException("El Numero del Turno es requerido para Usar el Turno");
        }

        if ($estado === null || empty(trim($estado <= 0))) {
            throw new InvalidArgumentException("El Estado del Turno es requerido para Usar el Turno");
        }

        if ($fecha_uso === null) {
            throw new InvalidArgumentException("La fecha de uso es requerida al Usar el Turno");
        }

        if ($usuario_uso === null || $usuario_uso < 1) {
            throw new InvalidArgumentException("El Usuario que registra el Turno es requerido al Usar el Turno");
        }

        $this->id = $id;
        $this->numero = $numero;
        $this->estado = $estado;
        $this->fecha_uso = $fecha_uso;
        $this->usuario_uso = $usuario_uso;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNumero(): int
    {
        return $this->numero;
    }

    public function getEstado() : string
    {
        return $this->estado;
    }

    public function getFechaUso() : DateTime
    {
        return $this->fecha_uso;
    }
    public function getUsuarioUso() : int 
    {
        return $this->usuario_uso;
    }
}
