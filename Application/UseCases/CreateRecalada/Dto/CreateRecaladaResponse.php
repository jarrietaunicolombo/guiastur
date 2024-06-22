<?php
class CreateRecaladaResponse
{
    private $id;
    private $recalada;

    public function __construct(int $id, CreateRecaladaRequest $recalada)
    {
        if (!isset($id) || $id <= 0) {
            throw new \InvalidArgumentException("El ID de la nueva Recalada creada es requerido");
        }

        if (!isset($recalada)) {
            throw new \InvalidArgumentException("La nueva Recalada creada es requerida");
        }
        $this->id = $id;
        $this->recalada = $recalada;
    }

    public function getId(): int{
        return $this->id;
    }

    public function getRecalada(): CreateRecaladaRequest{
        return $this->recalada;
    }
    
}