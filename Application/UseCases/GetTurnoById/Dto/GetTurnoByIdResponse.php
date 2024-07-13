<?php
class GetTurnoByIdResponse
{
    private $id;
    private $numero;
    private $estado;
    private $fecha_uso;
    private $usuario_uso;
    private $fecha_salida;
    private $usuario_salida;
    private $fecha_regreso;
    private $usuario_regreso;
    private $observaciones;
    private $guia;
    private $atencion;
    private $fecha_registro;
    private $usuario_registro;

    public function __construct(
        int $id,
        int $numero,
        string $estado,
        DateTime $fecha_uso = null,
        int $usuario_uso = null,
        DateTime $fecha_salida = null,
        int $usuario_salida  = null,
        DateTime $fecha_regreso = null,
        int $usuario_regreso = null,
        string $observaciones = null,
        GuiaTurnoDto $guia,
        AtencionTurnoDto $atencion,
        DateTime $fecha_registro,
        int $usuario_registro
    ) {
        if ($id === null || $id < 1) {
            throw new InvalidArgumentException("El ID del Turno es requerido para Obtener el Turno por Id");
        }
        if ($estado === null || empty(trim($estado <= 0))) {
            throw new InvalidArgumentException("El Estado del Turno es requerido para Obtener el Turno por Id");
        }

        if ($numero === null || $numero < 1) {
            throw new InvalidArgumentException("El Numero del Turno es requerido para Obtener el Turno por Id");
        }

        if ($guia === null) {
            throw new InvalidArgumentException("El Guia es requerido para Obtener el Turno por Id");
        }

        if ($atencion === null) {
            throw new InvalidArgumentException("La Atencion es requerida para Obtener el Turno por Id");
        }

        if ($fecha_registro === null) {
            throw new InvalidArgumentException("La Fecha de Registro es requerida para Obtener el Turno por Id");
        }

        if ($usuario_registro === null) {
            throw new InvalidArgumentException("El Usuario que Registró es requerido para Obtener el Turno por Id");
        }

        $this->id = $id;
        $this->numero = $numero;
        $this->estado = $estado;
        $this->fecha_uso = $fecha_uso;
        $this->usuario_uso = $usuario_uso;
        $this->fecha_salida = $fecha_salida;
        $this->usuario_salida = $usuario_salida;
        $this->fecha_regreso = $fecha_regreso;
        $this->usuario_regreso = $usuario_regreso;
        $this->observaciones = $observaciones;
        $this->guia = $guia;
        $this->atencion = $atencion;
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

    public function getEstado() : string
    {
        return $this->estado;
    }

    public function getFechaUso() 
    {
        return $this->fecha_uso;
    }

    public function getFechaSalida() 
    {
        return $this->fecha_salida;
    }

    public function getFechaRegreso() 
    {
        return $this->fecha_regreso;
    }

    public function getUsuarioUso(){
        return $this->usuario_uso;
    }

    public function getUsuarioSalida(){
        return $this->usuario_salida;
    }

    public function getUsuarioRegreso(){
        return $this->usuario_regreso;
    }
    public function getObservaciones() 
    {
        return $this->observaciones;
    }

    public function getGuia(): GuiaTurnoDto
    {
        return $this->guia;
    }

    public function getAtencion() : AtencionTurnoDto{
        return $this->atencion;
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

class GuiaTurnoDto{
    public $usuario_id;
    private $cedula;
    private $rnt;
    private $nombre;
    private $telefono;
    private $foto;

    public function __construct(int $usuario_id, string $cedula, string $rnt, string $nombre, string $telefono = null, string $foto = null) {
        if($usuario_id === null || $usuario_id < 1) {
            throw new InvalidArgumentException("El Id del Usuario Guia es requerida para Obtener el Turno por Id");
        }
        
        if($cedula === null || empty(trim($cedula))) {
            throw new InvalidArgumentException("La Cedula del Guia es requerida para Obtener el Turno por Id");
        }

        if($rnt === null || empty(trim($rnt))) {
            throw new InvalidArgumentException("El RNT del Guia es requerido para Obtener el Turno por Id");
        }

        if($nombre === null || empty(trim($nombre))) {
            throw new InvalidArgumentException("El Nombre del Guia es requerido para Obtener el Turno por Id");
        }
        $this->usuario_id = $usuario_id;
        $this->cedula = $cedula;
        $this->rnt = $rnt;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->foto = $foto;
    }

    public function getUsuarioId(): int {
        return $this->usuario_id;
    }

        
    public function getCedula(): string{
        return $this->cedula;
    }

    public function getRnt(): string {
        return $this->rnt;
    }

    public function getNombre(): string {   
        return $this->nombre;
    }

    public function getTelefono() {
        return $this->telefono;
    }
    public function getFoto(){
        return $this->foto;
    }
    
}

class AtencionTurnoDto{
    private $id;
    private $fecha_inicio;
    private $fecha_cierre;
    private $total_turnos;

    public function __construct(int $id, DateTime $fecha_inicio , DateTime $fecha_cierre = null, int $total_turnos) {
        if($id === null || $id < 1 ) {
            throw new InvalidArgumentException("El Id de la Atencion es requerido para Obtener el Turno por Id");
        }

        if($fecha_inicio === null) {
            throw new InvalidArgumentException("La Fecha de Inicio de la Atencion es requerida para Obtener el Turno por Id");
        }

        if($total_turnos === null || $total_turnos < 1) {
            throw new InvalidArgumentException("El Total Tornos de la Atencion es requerido para Obtener el Turno por Id");
        }

        $this->id = $id;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_cierre = $fecha_cierre;
        $this->total_turnos = $total_turnos;

    }

    public function getId(): int {
        return $this->id;
    }

    public function getFechaInicio(): DateTime {
        return $this->fecha_inicio;
    }

    public function getFechaCierre() {
        return $this->fecha_cierre;
    }

    public function getTotalTurnos(): int {
        return $this->total_turnos;
    }
}
