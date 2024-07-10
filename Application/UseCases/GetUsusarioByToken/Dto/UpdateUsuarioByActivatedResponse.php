<?php
class UpdateUsuarioByActivatedResponse
{
    private $email;
    private $nombre;
    private $rol_nombre;
    private $password;

    public function __construct(
        string $email,
        string $nombre,
        string $password,
        string $rol_nombre
    ) {
        if (empty(trim($email))) {
            throw new InvalidArgumentException("El Email es requerido al Actualizar Usuario por Activacion");
        }
     
        if (empty(trim($nombre))) {
            throw new InvalidArgumentException("El Nombre es requerido al Actualizar Usuario por Activacion");
        }
        if (empty(trim($password))) {
            throw new InvalidArgumentException("El Password es requerido al Actualizar Usuario por Activacion");
        }
        if (empty(trim($rol_nombre))) {
            throw new InvalidArgumentException("El Rol es requerido al Actualizar Usuario por Activacion");
        }

        $this->nombre = $nombre;
        $this->email = $email;
        $this->rol_nombre = $rol_nombre;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    public function getNombre(): string
    {
        return $this->nombre;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getRolNombre(): string
    {
        return $this->rol_nombre;
    }

}
