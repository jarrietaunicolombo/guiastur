<?php

class GetAtencionByIdRequest{
    private $atencionId;

    public function __construct(int $atencionId)
    {
        if (!isset($atencionId) || $atencionId < 1) {
            throw new InvalidArgumentException("El Id de la Atencion es requerido para Obtener Atenciones po Id");
        }
        $this->atencionId = $atencionId;

    }


    public function getAtencionId() : int
    {
        return $this->atencionId;
    }

}