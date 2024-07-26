<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GenericDto.php";

class ReleaseTurnoResponse extends GenericDto
{
    private $id;
    private $numero;
    private $estado;
    private $fecha_salida;
    private $usuario_salida;
   

    public function __construct(
        int $id,
        int $numero,
        string $estado,
        DateTime $fecha_salida ,
        int $usuario_salida 
    
    ) {
        if ($id === null || $id < 1) {
            throw new InvalidArgumentException("El ID del Turno es requerido para Liberar el Turno");
        }
        if ($estado === null || empty(trim($estado <= 0))) {
            throw new InvalidArgumentException("El Estado del Turno es requerido para Liberar el Turno");
        }

        if ($numero === null || $numero < 1) {
            throw new InvalidArgumentException("El Numero del Turno es requerido para Liberar el Turno");
        }
        if ($fecha_salida === null) {
            throw new InvalidArgumentException("La Fecha de salida es requerida para Liberar el Turno");
        }

        if ($usuario_salida === null) {
            throw new InvalidArgumentException("El Usuario que Registró la salida es requerido para Liberar el Turno");
        }

        $this->id = $id;
        $this->numero = $numero;
        $this->estado = $estado;
        $this->fecha_salida = $fecha_salida;
        $this->usuario_salida = $usuario_salida;
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


    public function getFechaSalida() : DateTime
    {
        return $this->fecha_salida;
    }

    public function getUsuarioSalida() : int{
        return $this->usuario_salida;
    }
}
