<?php
class CreateUserGuiaResponse
{
    private $usuario;

    public function __construct(CreateUserGuiaRequest $usuario)
    {
        if (!isset($usuario)) {
            throw new \InvalidArgumentException("El nuevo Usuario Guia es requerido");
        }

        $this->usuario = $usuario;
    }

    public function getUsuario(): CreateUserGuiaRequest
    {
        return $this->usuario;
    }

}