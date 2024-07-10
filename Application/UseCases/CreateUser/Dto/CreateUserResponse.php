<?php
require_once __DIR__ ."/CreateUserRequest.php";
class CreateUserResponse extends CreateUserRequest
{

    protected $id;
    protected $validation_token;
    protected $rol_nombre;
    protected $guia_o_supervisor;


    public function __construct(
        int $id,
        string $email,
        string $password,
        string $nombre,
        string $estado,
        int $rol_id,
        string $rol_nombre,
        string $validation_token,
        int $usuario_create,
        DateTime $fecha_registro
    ) {
        if ( $id <= 0) {
            throw new InvalidArgumentException("El Id del nuevo Usuario es requerido");
        }

        if ( empty(trim($email))) {
            throw new InvalidArgumentException("El Email es requerido");
        }

        if (empty(trim($password))) {
            throw new InvalidArgumentException("El Password es requerido");
        }

        if (empty(trim($nombre))) {
            throw new InvalidArgumentException("El Nombre es requerido");
        }

        if ( empty(trim($estado))) {
            throw new InvalidArgumentException("El Estado es requerido");
        }

        if ( $rol_id < 1) {
            throw new InvalidArgumentException("El Rol es requerido");
        }

        if ( empty(trim($rol_nombre))) {
            throw new InvalidArgumentException("El Nombre del Rol del nuevo Usuario es requerido");
        }

        if ( empty(trim($validation_token))) {
            throw new InvalidArgumentException("El Token de Validacion del nuevo Usuario es requerido");
        }

        if ($usuario_create < 1) {
            throw new InvalidArgumentException("El Usuario creador es requerido");
        }

        if ($fecha_registro > new DateTime()){
            throw new InvalidArgumentException("La Fecha de Registro no puede ser mayor a la fecha actual al crear un Usuario");
        }

        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->estado = $estado;
        $this->rol_id = $rol_id;
        $this->validation_token = $validation_token;
        $this->rol_nombre = $rol_nombre;
        $this->usuario_registro = $usuario_create;
        $this->fecha_registro = $fecha_registro;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getValidationToken(): string
    {
        return $this->validation_token;
    }

    public function getRolNombre(): string
    {
        return $this->rol_nombre;
    }

    public function getGuiaOSupervisor()
    {
        return $this->guia_o_supervisor;
    }

}
