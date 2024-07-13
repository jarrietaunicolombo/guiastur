<?php

class GetUsuarioByIdResponse
{

    private $id;
    private $nombre;
    private $email;
    private $estado;
    private $guia_o_supervisor;
    private $validation_token;
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
        if($id === null || $id < 1){
            throw new InvalidArgumentException("El ID del Usuario es requerido para Obtener Usuario Por Id");
        }

        if($nombre === null || empty(trim($nombre))) {
            throw new InvalidArgumentException("El Nombre del Usuario es requerido para Obtener Usuario Por Id");
        }

        if($estado === null || empty(trim($estado))) {
            throw new InvalidArgumentException("El Estado del Usuario es requerido para Obtener Usuario Por Id");
        }

        if($email === null || empty(trim($email))) {
            throw new InvalidArgumentException("El Email del Usuario es requerido para Obtener Usuario Por Id");
        }

        if($estado === null || empty(trim($estado))) {
            throw new InvalidArgumentException("El Estado del Usuario es requerido para Obtener Usuario Por Id");
        }

        if($rol_id === null ||  $rol_id < 1){
            throw new InvalidArgumentException("El Rol Id del Usuario es requerido para Obtener Usuario Por Id");
        }
        
        if($rol_nombre === null || empty(trim($nombre))){
            throw new InvalidArgumentException("El Nombre del ROl del Usuario es requerido para Obtener Usuario Por Id");
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