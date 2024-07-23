<?php

class GetRecaladaByIdRequest{
    private $recaladaId;

    public function __construct(int $recaladaId)
    {
        if (!isset($recaladaId) || $recaladaId < 1) {
            throw new InvalidArgumentException("La Recalada Id es requerida para obtener la Recalada por Id");
        }
        $this->recaladaId = $recaladaId;
    }


    public function getRecaladaId() : int
    {
        return $this->recaladaId;
    }

}