<?php
class CreateUserSupervisorResponse
{
    private $usuario;

    public function __construct(CreateUserSupervisorRequest $usuario)
    {
        if (!isset($usuario)) {
            throw new \InvalidArgumentException("El nuevo Usuario requerido para crear n Supervisor");
        }

        $this->usuario = $usuario;
    }

    public function getUsuario(): CreateUserSupervisorRequest
    {
        return $this->usuario;
    }

}