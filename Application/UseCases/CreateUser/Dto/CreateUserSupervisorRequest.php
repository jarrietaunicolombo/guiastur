<?php
class CreateUserSupervisorRequest
{
    private $usuario;
    private $cedula;
    private $rnt;
    private $nombres;
    private $fecha_registro;

    public function __construct(string $cedula, string $rnt, CreateUserResponse $usuario)
    {
        if (!isset($cedula) || empty(trim($cedula))) {
            throw new \InvalidArgumentException("La Cedula es requerida para Crear un Usuario Supervisor");
        }
        if (!isset($rnt) || empty(trim($rnt))) {
            throw new \InvalidArgumentException("El RNT es requerido para Crear un Usuario Supervisor");
        }
        if (!isset($usuario) ) {
            throw new \InvalidArgumentException("El Usuario es requerido para Crear un Usuario Supervisor");
        }

        $this->cedula = $cedula;
        $this->rnt = $rnt;
        $this->nombres = $usuario->getUsuario()->getNombre();
        $this->fecha_registro = new DateTime();
        $this->usuario = $usuario;
    }

    public function getUsuario(): CreateUserResponse {
        return $this->usuario;
    }
    
    public function getCedula(): string {
        return $this->cedula;
    }
   
    public function getRnt(): string {
        return $this->rnt;
    }
    
    public function getNombres(): string {
        return $this->nombres;
    }
    
    public function getFechaRegistro(): DateTime {
        return $this->fecha_registro;
    }
}