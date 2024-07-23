<?php
class CreateAtencionRequest
{
    private $fecha_inicio;
    private $fecha_cierre;
    private $total_turnos;
    private $observaciones;
    private $supervisor_id;
    private $recalada_id;
    private $fecha_registro;
    private $usuario_registro;

    public function __construct(
        DateTime $fecha_inicio,
        DateTime $fecha_cierre = null,
        int $total_turnos ,
        string $observaciones = null,
        string $supervisor_id = null,
        int $recalada_id,
        int $usuario_registro
    ) {
        if(!isset($fecha_inicio)){
            throw new InvalidArgumentException("La Fecha de Inicio es requerida para una nueva Atecion");
        }
        if(!isset($total_turnos) || $total_turnos <= 0){
            throw new InvalidArgumentException("El Total de Turnos es requerido para una nueva Atecion");
        }

        if(!isset($recalada_id) || $recalada_id <= 0){
            throw new InvalidArgumentException("La RecaladaId es requerida para una nueva Atecion");
        }

        if(!isset($usuario_registro) || $usuario_registro <= 0){
            throw new InvalidArgumentException("El UsuarioRegistroId es requerido para una nueva Atecion");
        }

        if(!isset($fecha_cierre) && $fecha_cierre < $fecha_inicio){
            throw new InvalidArgumentException("La Fecha de Inicio no puede ser mayor que la Fecha de Cierre en la nueva Atencion");
        }   

        if(!isset($supervisor_id) && empty(trim($supervisor_id))){
            throw new InvalidArgumentException("El SupervisorId está incorrecto en la nueva Atencion");
        }   

        if(!isset($observaciones) && empty(trim($observaciones))){
            $observaciones = null;
        }

        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_cierre = $fecha_cierre;
        $this->total_turnos = $total_turnos;
        $this->observaciones = $observaciones;
        $this->supervisor_id = $supervisor_id;
        $this->recalada_id = $recalada_id;
        $this->fecha_registro = new DateTime();
        $this->usuario_registro = $usuario_registro;
    }

    public function getFechaInicio() : DateTime
    {
        return $this->fecha_inicio;
    }



    public function getFechaCierre() : DateTime
    {
        return $this->fecha_cierre;
    }


    public function getTotalTurnos() : int 
    {
        return $this->total_turnos;
    }


    public function getObservaciones() : string
    {
        return $this->observaciones;
    }

    public function getSupervisorId() : string
    {
        return $this->supervisor_id;
    }


    public function getRecaladaId() : int
    {
        return $this->recalada_id;
    }



    public function getFechaRegistro() : DateTime
    {
        return $this->fecha_registro;
    }


    public function getUsuarioRegistro() : int
    {
        return $this->usuario_registro;
    }

}

