<?php
class LoginResponse
{
    private  $id;
    private  $email;
    private  $nombre;
    private  $estado;
    private  $rol;
    private  $guia_o_supervisor;

    public function __construct(int $id, string $email, string $nombre, string $estado, string $rol, string $guia_o_supervisor)
    {
        $this->setId($id);
        $this->setEmail($email);
        $this->setNombre($nombre);
        $this->setEstado($estado);
        $this->setRol($rol);
        $this->setGuiaOSupervisor($guia_o_supervisor);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado)
    {
        $this->estado = $estado;
    }

    public function getRol(): string
    {
        return $this->rol;
    }

    public function setRol(string $rol)
    {
        $this->rol = $rol;
    }

    public function getGuiaOSupervisor()
    {
        return $this->guia_o_supervisor;
    }

    public function setGuiaOSupervisor(string $guia_o_supervisor)
    {
        $this->guia_o_supervisor = $guia_o_supervisor;
    }
}

