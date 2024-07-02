<?php
class CreateUserResponse
{

    private $id;
    private $validation_token;
    private $usuario;
    private $rol_nombre;


    public function __construct(int $id, string $validation_token, string $rol_nombre, CreateUserRequest $usuario)
    {
        if (!isset($id) || $id <= 0) {
            throw new \InvalidArgumentException("El Id del nuevo Usuario es requerido");
        }

        if (!isset($validation_token) || empty(trim($validation_token))) {
            throw new \InvalidArgumentException("El Token de Validacion del nuevo Usuario es requerido");
        }


        if (!isset($rol_nombre) || empty(trim($rol_nombre))) {
            throw new \InvalidArgumentException("El Nombre del Rol del nuevo Usuario es requerido");
        }

        if (!isset($usuario)) {
            throw new \InvalidArgumentException("El nuevo Usuario es requerido");
        }

        $this->id = $id;
        $this->usuario = $usuario;
        $this->validation_token = $validation_token;
        $this->rol_nombre = $rol_nombre;

    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getUsuario(): CreateUserRequest
    {
        return $this->usuario;
    }
    public function setUsuario(CreateUserRequest $usuario)
    {
        $this->usuario = $usuario;
    }
    public function getValidationToken(): string
    {
        return $this->validation_token;
    }

    public function setValidationToken(string $validation_token)
    {
        $this->validation_token = $validation_token;
    }
    public function getRolNombre(): string
    {
        return $this->rol_nombre;
    }
    public function setRolNombre(string $rol_nombre)
    {
        $this->rol_nombre = $rol_nombre;
    }
}
