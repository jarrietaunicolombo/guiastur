<?php
class CreateUserRequest
{

    protected $email;
    protected $password;
    protected $nombre;
    protected $estado;
    protected $rol_id;
    protected $fecha_registro;
    protected $usuario_registro;

    public function __construct(
        string $email,
        string $password,
        string $nombre,
        int $rol_id,
        int $usuario_create
    ) {
        if (!isset($email) || empty(trim($email))) {
            throw new InvalidArgumentException("El Email es requerido");
        }
        if (!isset($password) || empty(trim($password))) {
            throw new InvalidArgumentException("El Password es requerido");
        }
        if (!isset($nombre) || empty(trim($nombre))) {
            throw new InvalidArgumentException("El Nombre es requerido");
        }
        if (!isset($rol_id) || $rol_id < 1) {
            throw new InvalidArgumentException("El Rol es requerido");
        }
        if (!isset($usuario_create) || $usuario_create < 1) {
            throw new InvalidArgumentException("El Usuario creador es requerido");
        }
        $this->email = $email;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->estado = "Created";
        $this->rol_id = $rol_id;
        $this->usuario_registro = $usuario_create;
        $this->fecha_registro = new DateTime();
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPassword(): string
    {
        return $this->password;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getRolId(): int
    {
        return $this->rol_id;
    }

    public function getUsuarioRegistro(): int
    {
        return $this->usuario_registro;
    }
    public function getFechaRegistro(): DateTime
    {
        return $this->fecha_registro;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }
  
}