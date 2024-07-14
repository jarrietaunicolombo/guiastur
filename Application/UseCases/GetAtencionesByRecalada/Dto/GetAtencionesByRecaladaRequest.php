<?php

class GetAtencionesByRecaladaRequest{
    private $recaladaId;

    public function __construct(int $recaladaId)
    {
        if ($recaladaId < 1) {
            throw new \InvalidArgumentException("La Recalada Id es requerida para Obtener Atenciones  Por Recalada");
        }
        $this->recaladaId = $recaladaId;

    }


    public function getRecaladaId()
    {
        return $this->recaladaId;
    }

}