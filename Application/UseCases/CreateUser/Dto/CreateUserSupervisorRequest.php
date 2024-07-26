<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Constants/UsuarioStatus.php";
require_once __DIR__ ."/CreateUserResponse.php";
class CreateUserSupervisorRequest extends CreateUserResponse
{
    protected $cedula;
    protected $rnt;
    protected $nombres;
    protected $apellidos;
    protected $genero;
    protected $fecha_nacimiento;
    protected $telefono;
    protected $foto;
    protected $observaciones;

    public function __construct(
        int $id,
        string $email,
        string $password,
        string $nombre,
        int $rol_id,
        string $rol_nombre,
        string $validation_token,
        string $cedula,
        string $rnt,
        string $nombres,
        string $apellidos,
        string $genero,
        DateTime $fecha_nacimiento,
        string $telefono,
        string $foto = null,
        string $observaciones = null,
        int $usuario_create
    ) {
        if ( $id <= 0) {
            throw new InvalidArgumentException("El Id   es requerido al crear un nuevo Usuario Supervisor al crear un nuevo Usuario Supervisor");
        }

        if ( empty(trim($email))) {
            throw new InvalidArgumentException("El Email  es requerido al crear un nuevo Usuario Supervisor");
        }

        if (empty(trim($password))) {
            throw new InvalidArgumentException("El Password  es requerido al crear un nuevo Usuario Supervisor");
        }

        if (empty(trim($nombre))) {
            throw new InvalidArgumentException("El Nombre  es requerido al crear un nuevo Usuario Supervisor");
        }

        if ( $rol_id < 1) {
            throw new InvalidArgumentException("El Rol  es requerido al crear un nuevo Usuario Supervisor");
        }

        if ( empty(trim($rol_nombre))) {
            throw new InvalidArgumentException("El Nombre del Rol   es requerido al crear un nuevo Usuario Supervisor al crear un nuevo Usuario Supervisor");
        }

        if ( empty(trim($validation_token))) {
            throw new InvalidArgumentException("El Token de Validacion   es requerido al crear un nuevo Usuario Supervisor al crear un nuevo Usuario Supervisor");
        }

        if ($usuario_create < 1) {
            throw new InvalidArgumentException("El Usuario creador  es requerido al crear un nuevo Usuario Supervisor");
        }

        if ($cedula === null || empty(trim($cedula))) {
            throw new InvalidArgumentException("La Cedula es requerida al crear un nuevo usuario guia");
        }

        if ($rnt === null || empty(trim($rnt))) {
            throw new InvalidArgumentException("El RNT  es requerido al crear un nuevo Usuario Supervisor para crear un nuevo usuario guia");
        }

        if ($nombres === null || empty(trim($nombres))) {
            throw new InvalidArgumentException("El Nombre  es requerido al crear un nuevo Usuario Supervisor para crear un nuevo usuario guia");
        }

        if ($apellidos === null || empty(trim($apellidos))) {
            throw new InvalidArgumentException("Los Apellidos son requeridos para crear un nuevo usuario guia");
        }

        if ($genero === null || empty(trim($genero))) {
            throw new InvalidArgumentException("El Genero  es requerido al crear un nuevo Usuario Supervisor para crear un nuevo usuario guia");
        }

        if ($fecha_nacimiento === null) {
            throw new InvalidArgumentException("La Fecha de nacimiento es requerida para crear un nuevo usuario guia");
        }

        if ($fecha_nacimiento > new DateTime()) {
            throw new InvalidArgumentException("La Fecha de nacimiento no puede ser mayor a la fecha de creacion del nuevo usuario guia");
        }

        if ($telefono === null || empty(trim($telefono))) {
            throw new InvalidArgumentException("El Telefono   es requerido al crear un nuevo Usuario Supervisor para crear un nuevo usuario guia");
        }
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->rol_id = $rol_id;
        $this->validation_token = $validation_token;
        $this->rol_nombre = $rol_nombre;
        $this->cedula = $cedula;
        $this->rnt = $rnt;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->genero = $genero;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->estado = UsuarioStatus::ACTIVATED;
        $this->telefono = $telefono;
        $this->observaciones = $observaciones;
        $this->foto = $foto;
        $this->fecha_registro = new DateTime();
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

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function getObservaciones()
    {
        return $this->observaciones;
    }

    public function getFoto(){
        return $this->foto;
    }
    
}