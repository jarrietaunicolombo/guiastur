<?php
class FinishTurnoResponse extends GenericDto
{
    private $id;
    private $numero;
    private $estado;
       private $fecha_regreso;
    private $usuario_regreso;
    private $observaciones;
    
    public function __construct(
        int $id,
        int $numero,
        string $estado,
      
        DateTime $fecha_regreso = null,
        int $usuario_regreso = null,
        string $observaciones = null
       
    ) {
        if ($id === null || $id < 1) {
            throw new InvalidArgumentException("El ID del Turno es requerido para Finalizar el Turno");
        }
        if ($estado === null || empty(trim($estado <= 0))) {
            throw new InvalidArgumentException("El Estado del Turno es requerido para Finalizar el Turno");
        }

        if ($numero === null || $numero < 1) {
            throw new InvalidArgumentException("El Numero del Turno es requerido para Finalizar el Turno");
        }

        $this->id = $id;
        $this->numero = $numero;
        $this->estado = $estado;
        $this->fecha_regreso = $fecha_regreso;
        $this->usuario_regreso = $usuario_regreso;
        $this->observaciones = $observaciones;
      
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
    public function getFechaRegreso() : DateTime
    {
        return $this->fecha_regreso;
    }

    public function getUsuarioRegreso(): int{
        return $this->usuario_regreso;
    }
    public function getObservaciones() 
    {
        return $this->observaciones;
    }
}
