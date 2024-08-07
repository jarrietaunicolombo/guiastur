<?php
class GetTurnosByAtencionResponse
{
    private $total_turnos;
    private $turnos_asignados;
    private $turnos_creados;
    private $turnos_usados;
    private $turnos_liberados;
    private $turnos_finalizados;
    private $atencion_id;
    private $turnos;

    public function __construct(
            int $total_turnos, 
            int $atencion_id, 
            int $turnos_asignados,
            int $turnos_creados = 0, 
            int $turnos_usados = 0,
            int $turnos_liberados = 0, 
            int $turnos_finalizados = 0, 
            array $turnos) 
    {
    
        if ($total_turnos === null || $total_turnos <= 0) {
            throw new \InvalidArgumentException("El Numero de Turnos es requerido para obtener Turnos por Atencion");
        }
        if ($atencion_id === null || $atencion_id <= 0) {
            throw new \InvalidArgumentException("El AtencionId es requerido para obtener Turnos por Atencion");
        }
      
        if ($turnos === null) {
            throw new \InvalidArgumentException("El TurnoDto es requerido para obtener Turnos por Atencion");
        }
        if (count($turnos) <= 0) {
            throw new \InvalidArgumentException("La lista de TurnosDto es requerida para obtener Turnos por Atencion");
        }
        if (count($turnos) > 0 && !$turnos[0] instanceof GetTurnosByAtencionDto) {
            throw new \InvalidArgumentException("El turno no corresponde a un TurnosDto");
        }

        $this->total_turnos = $total_turnos;
        $this->atencion_id = $atencion_id;
        $this->turnos_asignados = $turnos_asignados;
        $this->turnos_creados = $turnos_creados;
        $this->turnos_usados = $turnos_usados;
        $this->turnos_liberados = $turnos_liberados;
        $this->turnos_finalizados = $turnos_finalizados;
        $this->turnos = $turnos;
    }

    public function getTotalTurnos(): int
    {
        return $this->total_turnos;
    }

    public function getTurnos(): array 
    {
        return $this->turnos;
    }
    public function getAtencionId(): int
    {
            return $this->atencion_id;
    }

    public function getTurnosAsignados(): int
    {
        return $this->turnos_asignados;
    }
    public function getTurnosCreados(): int
    {
        return $this->turnos_creados;
    }

    public function getTurnosUsados(): int
    {   
        return $this->turnos_usados;
    }

    public function getTurnosFinalizados(): int
    {
        return $this->turnos_finalizados;
    }
    public function getTurnosLiberados(): int{
        return $this->turnos_liberados;
    }
}

class GetTurnosByAtencionDto
{
    private $id;
    private $numero;
    private $guia_id;
    private $guia_nombres;
    private $estado;
    private $fecha_uso;
    private $usuario_uso;
    private $fecha_salida;
    private $usuario_salida;
    private $fecha_regreso;
    private $usuario_regreso;
    private $observaciones;
    private $fecha_registro;
    private $usuario_registro;

    public function __construct(
        int $id,
        int $numero,
        string $estado = null,
        DateTime $fecha_uso = null,
        int $usuario_uso = null,
        DateTime $fecha_salida = null,
        int $usuario_salida  = null,
        DateTime $fecha_regreso = null,
        int $usuario_regreso = null,
        string $observaciones = null,
        string $guia_id,
        string $guia_nombres,
        DateTime $fecha_registro = null,
        int $usuario_registro = null
    ) {
        if ($id === null || $id <= 0) {
            throw new InvalidArgumentException("El ID del Turno es requerido al Obtener Turnos por Atencion");
        }
        if ($numero === null || $numero <= 0) {
            throw new InvalidArgumentException("El Numero del Turno es requerido al Obtener Turnos por Atencion");
        }

        if ($guia_id === null || empty(trim($guia_id))) {
            throw new InvalidArgumentException("El Id del Guia es requerido al Obtener Turnos por Atencion");
        }

        if ($guia_nombres === null || empty(trim($guia_nombres))) {
            throw new InvalidArgumentException("El Nombre del Guia es requerido al Obtener Turnos por Atencion");
        }
        $this->id = $id;
        $this->numero = $numero;
        $this->guia_id = $guia_id;
        $this->guia_nombres = $guia_nombres;
        $this->estado = $estado;
        $this->fecha_uso = $fecha_uso;
        $this->usuario_uso = $usuario_uso;
        $this->fecha_salida = $fecha_salida;
        $this->usuario_salida = $usuario_salida;
        $this->fecha_regreso = $fecha_regreso;
        $this->usuario_regreso = $usuario_regreso;
        $this->observaciones = $observaciones;
        $this->fecha_registro = $fecha_registro;
        $this->usuario_registro = $usuario_registro;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNumero(): int
    {
        return $this->numero;
    }

    public function getGuiaId(): string
    {
        return $this->guia_id;
    }

    public function getGuiaNombres() : string
    {
        return $this->guia_nombres;
    }

    public function getEstado() : string
    {
        return $this->estado;
    }


    public function getFechaUso() 
    {
        return $this->fecha_uso;
    }

    public function getUsuarioUso(){
        return $this->usuario_uso;
    }



    public function getFechaSalida() 
    {
        return $this->fecha_salida;
    }

    public function getUsuarioSalida(){
        return $this->usuario_salida;
    }


    public function getFechaRegreso() 
    {
        return $this->fecha_regreso;
    }


    public function getUsuarioRegreso(){
        return $this->usuario_regreso;
    }


    public function getObservaciones() 
    {
        return $this->observaciones;
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
