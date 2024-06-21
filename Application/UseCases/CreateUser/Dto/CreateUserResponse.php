<?php
class CreateUserResponse{

    private $id;
    private $email;
    private $nombre;
	private $estado;
    private $rol_id;
    private $rol_name;
    private $fecha_registro;
    private $usuario_registro;


    public function __construct(int $id, string $email, string $nombre, int $rol_id,  string $rol_name, string $estado) {
        if(!isset($id) || $id <= 0){
            throw new \InvalidArgumentException("El Id de Usuario es requerido");
        }
       
        if(!isset($email) || empty(trim($email))){
            throw new \InvalidArgumentException("El Email de Usuario es requerido");
        }
       
        if(!isset($nombre) || empty(trim($nombre))){
            throw new \InvalidArgumentException("El Nombre de Usuario es requerido");
        }
        if(!isset($rol_id) || $rol_id <= 0){
            throw new \InvalidArgumentException("El RolId del Usuario es requerido");
        }
       
        if(!isset($rol_name) || empty(trim($rol_name))){
            throw new \InvalidArgumentException("El Nombre del Rol del Usuario es requerido");
        }

        if(!isset($estado) || empty(trim($estado))){
            throw new \InvalidArgumentException("El Estado del Usuario es requerido");
        }

        $this->id = $id;
        $this->email = $email;
        $this->nombre = $nombre;
        $this->estado = $estado;
        $this->rol_id = $rol_id;
        $this->rol_name = $rol_name;
    }

    public function getId(): int { 
        return $this->id; 
    }
    public function setId(int $id) {
        $this->id = $id;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function getNombre(): string{
        return $this->nombre;
    }

    public function getRolId(): int {
        return $this->rol_id;
    }

    public function getUsuarioRegistro(): string{
        return $this->usuario_registro;
    }
    public function getFechaRegistro(): DateTime{
        return $this->fecha_registro;
    }

    public function getEstado(): string{
        return $this->estado;
    }

    public function setEmail(string $email){
        $this->email = $email;
    }
    
    public function setNombre(string $nombre) {
        $this->nombre = $nombre;
    }
    
    public function setRolId(int $rol_id) {
        $this->rol_id = $rol_id;
    }
    
    public function setUsuarioRegistro(string $usuario_registro) {
        $this->usuario_registro = $usuario_registro;
    }
    
    public function setFechaRegistro(DateTime $fecha_registro) {
        $this->fecha_registro = $fecha_registro;
    }
    
    public function setEstado(string $estado) {
        $this->estado = $estado;
    }
    
}
