<?php
class UpdateUsuarioByActivatedRequest
{
    private $usuario_id;
    private $guia_o_supervisor_id;
    private $password;

    public function __construct(
        int $usuario_id,
        string $guia_o_supervisor,
        string $password
    ) {
        if ($usuario_id < 1) {
            throw new InvalidArgumentException("El Usuario ID es requerido para Actualizar Usuario por Activacion");
        }

        if (empty(trim($guia_o_supervisor))) {
            throw new InvalidArgumentException("El Guia o Supervisor hijo es requerido para Actualizar Usuario por Activacion");
        }


        if (empty(trim($password))) {
            throw new InvalidArgumentException("El Password es requerido para Actualizar Usuario por Activacion");
        }

        $this->usuario_id = $usuario_id;
        $this->guia_o_supervisor_id = $guia_o_supervisor;
        $this->password = $password;
    }

    public function getUsuarioId(): int
    {
        return $this->usuario_id;
    }

    public function getGuiaOSupervisorId(): string
    {
        return $this->guia_o_supervisor_id;
    }
    public function getPassword(): string
    {
        return $this->password;
    }

}
