<?php
class GetUsuarioByTokenResponse
{
    private $id;
    private $email;
    private $password;
    private $nombre;
    private $estado;
    private $rol_id;
    private $token;
    private $rol_nombre;
    private $guia_o_supervisor;


    public function __construct(
        int $id,
        string $email,
        string $password,
        string $nombre,
        int $rol_id,
        string $rol_nombre,
        string $token,
        string $estado
    ) {
        if ($id === null || $id < 1) {
            throw new \InvalidArgumentException("El Id es requerido al Obtener Usuario Por Token");
        }

        if ($email === null || empty(trim($email))) {
            throw new \InvalidArgumentException("El Email es requerido al Obtener Usuario Por Token");
        }
        if ($password === null || empty(trim($password))) {
            throw new \InvalidArgumentException("El Password es requerido al Obtener Usuario Por Token");
        }

        if ($nombre === null || empty(trim($nombre))) {
            throw new \InvalidArgumentException("El Nombre es requerido al Obtener Usuario Por Token");
        }

        if ($rol_id === null || $rol_id < 1) {
            throw new \InvalidArgumentException("El Id del Rol es requerido al Obtener Usuario Por Token");
        }

        if ($rol_nombre === null || empty(trim($rol_nombre))) {
            throw new \InvalidArgumentException("El Nombre del Rol es requerido al Obtener Usuario Por Token");
        }

        if ($token === null || empty(trim($token))) {
            throw new \InvalidArgumentException("El Token es requerido al Obtener Usuario Por Token");
        }
        if ($estado === null || empty(trim($estado))) {
            throw new \InvalidArgumentException("El Estado es requerido al Obtener Usuario Por Token");
        }

        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->rol_id = $rol_id;
        $this->rol_nombre = $rol_nombre;
        $this->token = $token;
        $this->estado = $estado;
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getRolNombre(): string
    {
        return $this->rol_nombre;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }
}