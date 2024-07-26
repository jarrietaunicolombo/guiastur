<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GenericDto.php";
class GetSupervisorResponse extends GenericDto
{

    private $usuario;
    private $supervisor;


    public function __construct(UsuarioResponseDto $usuario, SupervisorResponseDto $supervisor)
    {
        if ($usuario === null) {
            throw new InvalidArgumentException("El usuario es requerido al Obtener un Supervidor");
        }

        if ($supervisor === null) {
            throw new InvalidArgumentException("El supervisor es requerido al Obtener un Supervidor");
        }

        $this->usuario = $usuario;
        $this->supervisor = $supervisor;
    }

    public function toJSON(): string
    {
        $json = [
            "usuario" => $this->usuario->toJSON(),
            "supervisor" => $this->supervisor->toJSON()
        ];
        return json_encode($json);
    }

    public function getSupervisor(): SupervisorResponseDto
    {
        return $this->supervisor;
    }

    public function getUsuario(): UsuarioResponseDto
    {
        return $this->usuario;
    }

}

class UsuarioResponseDto extends GenericDto
{

    private $id;
    private $nombre;
    private $email;
    private $estado;
    private $guia_o_supervisor = null;
    private $validation_token = null;
    private $fecha_registro;
    private $usuario_registro;
    private $rol_id;
    private $rol_nombre;

    public function __construct(
        int $id,
        string $nombre,
        string $email,
        string $estado,
        string $guia_o_supervisor = null,
        string $validation_token = null,
        DateTime $fecha_registro,
        int $usuario_registro,
        int $rol_id,
        string $rol_nombre
    ) {
        if ($id === null || $id < 1) {
            throw new InvalidArgumentException("El ID del Usuario es requerido para Obtener Usuario ");
        }

        if ($nombre === null || empty(trim($nombre))) {
            throw new InvalidArgumentException("El Nombre del Usuario es requerido para Obtener Usuario ");
        }

        if ($estado === null || empty(trim($estado))) {
            throw new InvalidArgumentException("El Estado del Usuario es requerido para Obtener Usuario ");
        }

        if ($email === null || empty(trim($email))) {
            throw new InvalidArgumentException("El Email del Usuario es requerido para Obtener Usuario ");
        }

        if ($estado === null || empty(trim($estado))) {
            throw new InvalidArgumentException("El Estado del Usuario es requerido para Obtener Usuario ");
        }

        if ($rol_id === null || $rol_id < 1) {
            throw new InvalidArgumentException("El Rol Id del Usuario es requerido para Obtener Usuario ");
        }

        if ($rol_nombre === null || empty(trim($nombre))) {
            throw new InvalidArgumentException("El Nombre del ROl del Usuario es requerido para Obtener Usuario");
        }

        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->estado = $estado;
        $this->guia_o_supervisor = $guia_o_supervisor;
        $this->rol_id = $rol_id;
        $this->rol_nombre = $rol_nombre;
        $this->fecha_registro = $fecha_registro;
        $this->usuario_registro = $usuario_registro;
        $this->validation_token = $validation_token;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getEstado()
    {
        return $this->estado;
    }


    public function getGuiaOSupervisor()
    {
        return $this->guia_o_supervisor;
    }

    public function getValidationToken()
    {
        return $this->validation_token;
    }

    public function getFechaRegistro(): DateTime
    {
        return $this->fecha_registro;
    }

    public function getUsuarioRegistro(): int
    {
        return $this->usuario_registro;
    }

    public function getRolId(): int
    {
        return $this->rol_id;
    }

    public function getRolNombre(): string
    {
        return $this->rol_nombre;
    }
}

class SupervisorResponseDto extends GenericDto
{
    private $cedula;
    private $rnt;
    private $nombres;
    private $apellidos;
    private $genero;
    private $fecha_nacimiento;
    private $telefono;
    private $foto = null;
    private $observaciones = null;
    private $usuario_create;
    private $fecha_registro;

    public function __construct(
        string $cedula,
        string $rnt,
        string $nombres,
        string $apellidos,
        string $genero,
        DateTime $fecha_nacimiento,
        string $telefono,
        string $foto = null,
        string $observaciones = null,
        int $usuario_create,
        DateTime $fecha_registro
    ) {

        if ($cedula === null || empty(trim($cedula))) {
            throw new InvalidArgumentException("La Cedula es requerida al crear un Supervisor");
        }

        if ($rnt === null || empty(trim($rnt))) {
            throw new InvalidArgumentException("El RNT  es requerido al crear un Supervisor ");
        }

        if ($nombres === null || empty(trim($nombres))) {
            throw new InvalidArgumentException("El Nombre  es requerido al crear un Supervisor ");
        }

        if ($apellidos === null || empty(trim($apellidos))) {
            throw new InvalidArgumentException("Los Apellidos son requeridos ");
        }

        if ($genero === null || empty(trim($genero))) {
            throw new InvalidArgumentException("El Genero  es requerido al crear un Supervisor ");
        }

        if ($fecha_nacimiento === null) {
            throw new InvalidArgumentException("La Fecha de nacimiento es requerida ");
        }

        if ($fecha_nacimiento > new DateTime()) {
            throw new InvalidArgumentException("La Fecha de nacimiento no puede ser mayor a la fecha de creacion del nuevo usuario guia");
        }

        if ($telefono === null || empty(trim($telefono))) {
            throw new InvalidArgumentException("El Telefono   es requerido al crear un Supervisor ");
        }

        if ($fecha_registro === null) {
            throw new InvalidArgumentException("La Fecha de registro es requerida al crear un Supervisor ");
        }

        if ($usuario_create === null) {
            throw new InvalidArgumentException("El Usuario que registra es requerido al crear un Supervisor ");
        }

        $this->cedula = $cedula;
        $this->rnt = $rnt;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->genero = $genero;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->telefono = $telefono;
        $this->observaciones = $observaciones;
        $this->foto = $foto;
        $this->fecha_registro = $fecha_registro;
        $this->usuario_registro = $usuario_create;
    }

    public function getCedula(): string
    {
        return $this->cedula;
    }

    public function getRnt(): string
    {
        return $this->rnt;
    }

    public function getNombres(): string
    {
        return $this->nombres;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function getGenero(): string
    {
        return $this->genero;
    }

    public function getFechaNacimiento(): DateTime
    {
        return $this->fecha_nacimiento;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function getObservaciones()
    {
        return $this->observaciones;
    }

    public function getUsuarioCreate(): int
    {
        return $this->usuario_create;
    }

    public function getFechaRegistro(): DateTime
    {
        return $this->fecha_registro;
    }
}


